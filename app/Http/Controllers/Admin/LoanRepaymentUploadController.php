<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LoanRepaymentTemplateExport;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\LoanRepayment;
use App\Models\LoanRepaymentUpload;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class LoanRepaymentUploadController extends Controller
{
    public function create()
    {
        return view('admin.loan-repayments.upload');
    }

    public function index()
    {
        $uploads = LoanRepaymentUpload::withCount('repayments')
            ->with('user:id,name')
            ->latest()
            ->paginate(10);

        return view('admin.loan-repayments.index', compact('uploads'));
    }

    public function show(LoanRepaymentUpload $loanRepaymentUpload)
    {
        $repayments = $loanRepaymentUpload->repayments()->with(['loan.member'])->latest()->get();
        $statusClass = match ($loanRepaymentUpload->status) {
            'success' => 'green',
            'failed' => 'red',
            'processing' => 'blue',
            default => 'gray',
        };

        return view('admin.loan-repayments.show', compact('loanRepaymentUpload', 'repayments', 'statusClass'));
    }

    public function downloadTemplate()
    {
        return Excel::download(new LoanRepaymentTemplateExport, 'loan_repayment_template.xlsx');
    }

    public function store(Request $request)
    {
        $request->validate([
            'repayment_file' => 'required|file|max:10240|mimes:csv,xlsx,xls',
        ]);

        $file = $request->file('repayment_file');
        $filename = time().'_'.$file->getClientOriginalName();
        $path = $file->storeAs('repayments', $filename, 'public');

        $recordsCreated = 0;
        $errors = [];

        try {
            $sheets = Excel::toArray([], $file);
            $rows = $sheets[0] ?? [];
            $header = array_shift($rows); // Skip header

            foreach ($rows as $index => $row) {
                if (count($row) < 6) {
                    continue;
                }

                $staffNo = trim($row[0] ?? '');
                $month = (int) ($row[1] ?? 0);
                $year = (int) ($row[2] ?? 0);
                $amount = (float) ($row[3] ?? 0);
                $paymentMethod = trim($row[4] ?? 'salary_deduction');
                $reference = trim($row[5] ?? '');

                if (! $staffNo || $month < 1 || $month > 12 || $year < 2000 || $amount <= 0) {
                    $errors[] = 'Row '.($index + 2).': Invalid data';

                    continue;
                }

                $member = Member::where('staff_no', $staffNo)->first();
                if (! $member) {
                    $errors[] = 'Row '.($index + 2).": Member not found for staff_no $staffNo";

                    continue;
                }

                $loan = Loan::active()
                    ->where('member_id', $member->id)
                    ->where('outstanding_balance', '>', 0)
                    ->first();
                if (! $loan) {
                    $errors[] = 'Row '.($index + 2).": No active loan for {$member->name} ($staffNo)";

                    continue;
                }

                $paymentDate = now()->setDate($year, $month, 1)->endOfMonth(); // Last day of month
                $installmentNumber = $loan->repayments()->count() + 1;

                $exists = LoanRepayment::where('loan_id', $loan->id)
                    ->where('payment_date', $paymentDate)
                    ->where('amount', $amount)
                    ->first();
                if ($exists) {
                    $errors[] = 'Row '.($index + 2).": Duplicate repayment for loan {$loan->application_ref}";

                    continue;
                }

                LoanRepayment::create([
                    'loan_id' => $loan->id,
                    'amount' => $amount,
                    'payment_date' => $paymentDate,
                    'installment_number' => $installmentNumber,
                    'payment_method' => $paymentMethod,
                    'reference' => $reference,
                    'notes' => 'Imported from bulk upload',
                    'loan_repayment_upload_id' => null, // Set after
                ]);

                $loan->applyRepayment($amount);

                $recordsCreated++;
            }
        } catch (\Exception $e) {
            $errors[] = 'Parse error: '.$e->getMessage();
        }

        $upload = LoanRepaymentUpload::create([
            'filename' => $filename,
            'file_path' => $path,
            'records_count' => $recordsCreated,
            'status' => $recordsCreated > 0 ? 'success' : 'failed',
            'notes' => $errors ? implode('; ', $errors) : 'Import completed',
        ]);

        // Link repayments
        LoanRepayment::where('notes', 'Imported from bulk upload')
            ->whereNull('loan_repayment_upload_id')
            ->where('created_at', '>=', now()->subMinutes(5))
            ->update(['loan_repayment_upload_id' => $upload->id]);

        if ($recordsCreated > 0) {
            return redirect()->route('admin.loan-repayments.index')->with('success', "Uploaded $filename: $recordsCreated repayments processed!");
        } else {
            Storage::disk('public')->delete($path);
            $upload->delete();

            return redirect()->back()->with('error', 'No valid records. Errors: '.implode(', ', $errors));
        }
    }
}
