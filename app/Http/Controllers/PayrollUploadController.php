<?php

namespace App\Http\Controllers;

use App\Exports\ContributionTemplateExport;
use App\Models\Contribution;
use App\Models\Member;
use App\Models\OpeningBalance;
use App\Models\PayrollUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PayrollUploadController extends Controller
{
    public function index()
    {
        $uploads = PayrollUpload::withCount('contributions')->with('user:id,name')->latest()->paginate(10);

        return view('admin.payroll-uploads.index', compact('uploads'));
    }

    public function show(PayrollUpload $payrollUpload)
    {
        $contributions = $payrollUpload->contributions()->with('member')->latest()->get();
        $statusClass = match ($payrollUpload->status) {
            'success' => 'green',
            'failed' => 'red',
            'processing' => 'blue',
            default => 'gray',
        };
        $upload = PayrollUpload::withCount('contributions')->latest()->first();

        return view('admin.payroll-uploads.show', compact('payrollUpload', 'contributions', 'statusClass', 'upload'));
    }

    public function downloadTemplate()
    {
        return Excel::download(new ContributionTemplateExport, 'staff_contribution_template.xlsx');
    }

    public function store(Request $request)
    {
        $request->validate([
            'payroll_file' => 'required|file|max:10240|mimes:csv,xlsx,xls', // 10MB
        ]);

        $file = $request->file('payroll_file');
        $filename = time().'_'.$file->getClientOriginalName();
        $path = $file->storeAs('payroll', $filename, 'public');

        $recordsCreated = 0;
        $errors = [];

        try {
            $sheets = Excel::toArray([], $file);
            $rows = $sheets[0] ?? []; // First sheet
            $header = array_shift($rows); // Skip header

            foreach ($rows as $index => $row) {
                if (count($row) < 6) {
                    continue;
                }

                $staffNo = trim($row[0] ?? '');
                $month = (int) ($row[1] ?? 1);
                $year = (int) ($row[2] ?? date('Y'));
                // $empAmount = (float) ($row[3] ?? 0);
                $name = trim($row[3] ?? '');
                $contribution_amount = (float) ($row[4] ?? 0);
                // $basic = (float) ($row[5] ?? 0);
                $type = trim($row[5] ?? 'Mandatory');
                // $ref = trim($row[7] ?? '');

                $member = Member::where('staff_no', $staffNo)->first();
                if (! $member) {
                    $errors[] = 'Row '.($index + 2).": Member not found for staff_no $staffNo";

                    continue;
                }

                $exists = Contribution::where('member_id', $member->id)
                    ->where('payroll_year', $year)
                    ->where('payroll_month', $month)
                    ->first();
                if ($exists) {
                    $errors[] = 'Row '.($index + 2).": Duplicate for {$member->name} ($month/$year)";

                    continue;
                }

                Contribution::create([
                    'member_id' => $member->id,
                    'staff_no' => $staffNo,
                    'payroll_year' => $year,
                    'payroll_month' => $month,
                    // 'employee_amount' => $empAmount,
                    // 'employer_amount' => $emplAmount,
                    'contribution_amount' => $contribution_amount,
                    'contribution_type' => $type,
                    'name' => $name,
                    'source' => 'payroll',
                    'status' => 'pending',
                    'payroll_upload_id' => null,
                    'notes' => 'Imported from payroll file',
                    'uploaded_by' => Auth::user()->name ?? 'Admin',
                ]);

                $recordsCreated++;
            }
        } catch (\Exception $e) {
            $errors[] = 'Parse error: '.$e->getMessage();
        }

        $upload = PayrollUpload::create([
            'filename' => $filename,
            'file_path' => $path,
            'records_count' => $recordsCreated,
            'status' => $recordsCreated > 0 ? 'success' : 'failed',
            'notes' => $errors ? implode('; ', $errors) : 'Import completed',
        ]);

        // Update contributions with upload ID
        $contcreate = Contribution::where('notes', 'Imported from payroll file')
            ->whereNull('payroll_upload_id')
            ->where('created_at', '>=', now()->subMinutes(5)) // Recent
            ->update(['payroll_upload_id' => $upload->id]);

        if ($contcreate) {
            // calculate opening balance for each contribution per each year and upload to opening balance table
            $contributions = Contribution::where('payroll_upload_id', $upload->id)->get();
            foreach ($contributions as $contribution) {
                $openingBalance = OpeningBalance::where('member_id', $contribution->member_id)
                    ->where('financial_year', $contribution->payroll_year)
                    ->first();
                if ($openingBalance) {
                    $openingBalance->update([
                        'amount' => $openingBalance->amount + $contribution->contribution_amount,
                    ]);
                } else {
                    OpeningBalance::create([
                        'member_id' => $contribution->member_id,
                        'financial_year' => $contribution->payroll_year,
                        'amount' => $contribution->contribution_amount,
                    ]);
                }
            }
            // return redirect()->back()->with('success', 'Contribution recorded successfully.');
        }
        // else {
        //     return redirect()->back()->with('error', 'Failed to record contribution. Please try again.');
        // }

        if ($recordsCreated > 0) {
            return redirect()->route('payroll-contribution.create')->with('success', "Uploaded $filename: $recordsCreated records imported successfully!");
        } else {
            Storage::disk('public')->delete($path);
            PayrollUpload::find($upload->id)->delete();

            return redirect()->back()->with('error', 'No valid records found. Errors: '.implode(', ', $errors));
        }
    }
}
