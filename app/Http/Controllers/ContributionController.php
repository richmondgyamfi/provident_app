<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Member;
use App\Models\OpeningBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recentContributions = Contribution::join('hr.staff', 'contributions.staff_no', '=', 'hr.staff.staff_no')
                ->select(
                    'contributions.*',
                    DB::raw("CONCAT(hr.staff.fname, ' ', hr.staff.mname, ' ', hr.staff.lname) AS name")
                )->recent()->get();
        $members = Member::join('hr.staff', 'members.staff_no', '=', 'hr.staff.staff_no')
                ->select(
                    'members.id',
                    'members.staff_no',
                    DB::raw("CONCAT(hr.staff.fname, ' ', hr.staff.mname, ' ', hr.staff.lname) AS name")
                )
                ->orderBy('name')
                ->get();

        //select all from opening balance and sum amount group by member_id
       $openingBalances = OpeningBalance::select( DB::raw('SUM(amount) as total_amount'))
                ->where('financial_year', date('Y'))
                ->get();
        
        $payrollUploads = \App\Models\PayrollUpload::withCount('contributions')
            ->with('user:id,name')
            ->latest()
            ->take(5)
            ->get();
            
        return view('admin.payroll-contribution', compact('recentContributions', 'members', 'openingBalances', 'payrollUploads'));
    }

    /**
     * Show create form for payroll contributions.
     */
    public function create()
    {
        $recentContributions = Contribution::join('hr.staff', 'contributions.staff_no', '=', 'hr.staff.staff_no')
                ->select(
                    'contributions.*',
                    DB::raw("CONCAT(hr.staff.fname, ' ', hr.staff.mname, ' ', hr.staff.lname) AS name")
                )->recent()->get();
        $members = Member::join('hr.staff', 'members.staff_no', '=', 'hr.staff.staff_no')
                ->select(
                    'members.id',
                    'members.staff_no',
                    DB::raw("CONCAT(hr.staff.fname, ' ', hr.staff.mname, ' ', hr.staff.lname) AS name")
                )
                ->orderBy('name')
                ->get();

        $openingBalances = OpeningBalance::select( DB::raw('SUM(amount) as total_amount'))
                ->where('financial_year', date('Y'))
                ->get();
        
        $payrollUploads = \App\Models\PayrollUpload::withCount('contributions')
            ->with('user:id,name')
            ->latest()
            ->take(5)
            ->get();
            
        return view('admin.payroll-contribution', compact('recentContributions', 'members','openingBalances', 'payrollUploads'));
    }

    public function edit(Contribution $contribution)
    {
        $contribution->load('member');
        $recentContributions = Contribution::join('hr.staff', 'contributions.staff_no', '=', 'hr.staff.staff_no')
                ->select(
                    'contributions.*',
                    DB::raw("CONCAT(hr.staff.fname, ' ', hr.staff.mname, ' ', hr.staff.lname) AS name")
                )->recent()->get();
        $members = Member::join('hr.staff', 'members.staff_no', '=', 'hr.staff.staff_no')
                ->select(
                    'members.id',
                    'members.staff_no',
                    DB::raw("CONCAT(hr.staff.fname, ' ', hr.staff.mname, ' ', hr.staff.lname) AS name")
                )
                ->orderBy('name')
                ->get();
        $openingBalances = OpeningBalance::select( DB::raw('SUM(amount) as total_amount'))
                ->where('financial_year', date('Y'))
                ->get();
        
        $payrollUploads = \App\Models\PayrollUpload::withCount('contributions')
            ->with('user:id,name')
            ->latest()
            ->take(5)
            ->get();
                // dd($openingBalances);
        return view('admin.payroll-contribution', compact('contribution', 'recentContributions', 'members','openingBalances', 'payrollUploads'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //store contribution
        // dd($request->all()); // Remove after testing
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'staff_no' => 'string|max:50',
            'payroll_year' => 'required|integer|min:2000|max:2100',
            'payroll_month' => 'required|integer|min:1|max:12',
            'employee_amount' => 'required|numeric|min:0',
            'employer_amount' => 'required|numeric|min:0',
            'basic_salary' => 'nullable|numeric|min:0',
            'contribution_type' => 'required|in:Mandatory,Voluntary,Arrears,Adjustment',
            'payment_reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'source' => 'required|in:payroll,manual',
        ]);

        if (!is_numeric($request->member_id)) {
            $member = Member::where('name', 'like', '%' . $request->member_id . '%')
                ->orWhere('staff_no', $request->member_id)
                ->firstOrFail();
            $request->merge(['member_id' => $member->id]);
            
        } else {
            $member = Member::findOrFail($request->member_id);
        }
        $request->merge(['staff_no' => $member->staff_no]);

        $data = $request->only([
            'staff_no',
            'payroll_year',
            'payroll_month',
            'employee_amount',
            'employer_amount',
            'basic_salary',
            'contribution_type',
            'payment_reference',
            'notes',
            'source'
        ]);
        $data['member_id'] = $request->member_id;
        $member = Member::findOrFail($data['member_id']);
        $data['staff_no'] = $member->staff_no ?? $request->staff_no;
        // $data['contribution_amount'] = $data['employee_amount'] + $data['employer_amount'];
        $data['contribution_amount'] = $data['employee_amount'] + $data['employer_amount'];
        $data['uploaded_by'] = Auth::user()->name ?? 'Admin';
        $data['status'] ??= 'pending';

        $getcontribution = Contribution::where('member_id', $data['member_id'])
            ->where('payroll_year', $data['payroll_year'])
            ->where('payroll_month', $data['payroll_month'])
            ->first();
        if ($getcontribution) {
            return redirect()->back()->with('error', 'Contribution for this member and payroll period already exists.');
        }

        $contcreate = Contribution::create($data);

        if($contcreate){
            $gettoallContribution = Contribution::where('member_id', $data['member_id'])->sum('contribution_amount');
            $totalContribution = $gettoallContribution;

            $openingBalaceupdate = OpeningBalance::where('member_id', $data['member_id'])
                ->where('financial_year', $data['payroll_year'])
                ->first();
            
            if ($openingBalaceupdate) {
                $openingBalaceupdate->amount = $totalContribution;
                $openingBalaceupdate->save();
            } else {
                OpeningBalance::create([
                    'member_id' => $data['member_id'],
                    'amount' => $totalContribution,
                    'financial_year' => $data['payroll_year'],
                ]);
            }
        return redirect()->back()->with('success', 'Contribution recorded successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to record contribution. Please try again.');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // show contribution details where status is not deleted
        $contribution = Contribution::where('id', $id)->where('status', '!=', 'deleted')->firstOrFail();
        return view('contributions.show', compact('contribution'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update contribution
        $contribution = Contribution::findOrFail($id);
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'staff_no' => 'required|string|max:50',
            'payroll_year' => 'required|integer|min:2000|max:2100',
            'payroll_month' => 'required|integer|min:1|max:12',
            'employee_amount' => 'required|numeric|min:0',
            'employer_amount' => 'required|numeric|min:0',
            'basic_salary' => 'nullable|numeric|min:0',
            'contribution_type' => 'required|in:Mandatory,Voluntary,Arrears,Adjustment',
            'payment_reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'source' => 'required|in:payroll,manual',
            'status' => 'nullable|string|max:50',
        ]);

        $data = $request->only([
            'member_id',
            'payroll_year',
            'payroll_month',
            'employee_amount',
            'employer_amount',
            'basic_salary',
            'contribution_type',
            'payment_reference',
            'notes',
            'source',
            'status'
        ]);
        $data['contribution_amount'] = $data['employee_amount'] + $data['employer_amount'];

        $contcreate = $contribution->update($data);

        if($contcreate){
            $gettoallContribution = Contribution::where('member_id', $data['member_id'])->sum('contribution_amount');
            $totalContribution = $gettoallContribution;

            $openingBalaceupdate = OpeningBalance::where('member_id', $data['member_id'])
                ->where('financial_year', $data['payroll_year'])
                ->first();
            
            if ($openingBalaceupdate) {
                $openingBalaceupdate->amount = $totalContribution;
                $openingBalaceupdate->save();
            } else {
                OpeningBalance::create([
                    'member_id' => $data['member_id'],
                    'amount' => $totalContribution,
                    'financial_year' => $data['payroll_year'],
                ]);
            }
        return redirect()->back()->with('success', 'Contribution updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to record contribution. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete by changing status to deleted
        $contribution = Contribution::findOrFail($id);
        $contribution->status = 'deleted';
        $contribution->save();
        return redirect()->back()->with('success', 'Contribution deleted successfully.');
    }
}
