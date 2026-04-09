<?php

namespace App\Http\Controllers;

use App\Models\PayrollUpload;
use App\Models\Contribution;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PayrollUploadController extends Controller
{
    public function index()
    {
        $uploads = PayrollUpload::withCount('contributions')->with('user:id,name')->latest()->paginate(10);
        return view('admin.payroll-uploads.index', compact('uploads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payroll_file' => 'required|file|max:10240|mimes:csv,xlsx,xls', // 10MB
        ]);

        $file = $request->file('payroll_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('payroll', $filename, 'public');

        // Basic CSV parsing (extend for XLSX later)
        $recordsCreated = 0;
        $errors = [];

        if ($file->getClientOriginalExtension() === 'csv') {
            $csv = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_shift($csv); // Skip header

            foreach ($csv as $index => $row) {
                if (count($row) < 8) continue; // Skip invalid rows

                // Assume CSV columns: staff_no, payroll_month, payroll_year, employee_amount, employer_amount, basic_salary, contribution_type, payment_reference
                $staffNo = trim($row[0] ?? '');
                $month = (int) ($row[1] ?? 1);
                $year = (int) ($row[2] ?? date('Y'));
                $empAmount = (float) ($row[3] ?? 0);
                $emplAmount = (float) ($row[4] ?? 0);
                $basic = (float) ($row[5] ?? 0);
                $type = trim($row[6] ?? 'Mandatory');
                $ref = trim($row[7] ?? '');

                $member = Member::where('staff_no', $staffNo)->first();
                if (!$member) {
                    $errors[] = "Row " . ($index+2) . ": Member not found for staff_no $staffNo";
                    continue;
                }

                // Check duplicate
                $exists = Contribution::where('member_id', $member->id)
                    ->where('payroll_year', $year)
                    ->where('payroll_month', $month)
                    ->first();
                if ($exists) {
                    $errors[] = "Row " . ($index+2) . ": Duplicate for {$member->name} ($month/$year)";
                    continue;
                }

                Contribution::create([
                    'member_id' => $member->id,
                    'staff_no' => $staffNo,
                    'payroll_year' => $year,
                    'payroll_month' => $month,
                    'employee_amount' => $empAmount,
                    'employer_amount' => $emplAmount,
                    'basic_salary' => $basic,
                    'contribution_type' => $type,
                    'payment_reference' => $ref,
                    'contribution_amount' => $empAmount + $emplAmount,
                    'source' => 'payroll',
                    'status' => 'pending',
                    'payroll_upload_id' => null, // Set after upload create
                    'notes' => 'Imported from payroll file',
                    'uploaded_by' => Auth::user()->name ?? 'Admin',
                ]);

                $recordsCreated++;
            }
        } else {
            // Placeholder for XLSX - skip or simple parse for now
            $errors[] = 'XLSX parsing not implemented yet. Please use CSV.';
        }

        $upload = PayrollUpload::create([
            'filename' => $filename,
            'file_path' => $path,
            'records_count' => $recordsCreated,
            'status' => $recordsCreated > 0 ? 'success' : 'failed',
            'notes' => $errors ? implode('; ', $errors) : 'Import completed',
        ]);

        // Update contributions with upload ID
        Contribution::where('notes', 'Imported from payroll file')
            ->whereNull('payroll_upload_id')
            ->where('created_at', '>=', now()->subMinutes(5)) // Recent
            ->update(['payroll_upload_id' => $upload->id]);

        if ($recordsCreated > 0) {
            return redirect()->route('payroll-contribution.create')->with('success', "Uploaded $filename: $recordsCreated records imported successfully!");
        } else {
            Storage::disk('public')->delete($path);
            PayrollUpload::find($upload->id)->delete();
            return redirect()->back()->with('error', 'No valid records found. Errors: ' . implode(', ', $errors));
        }
    }
}
