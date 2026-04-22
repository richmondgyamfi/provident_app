<?php

namespace App\Http\Controllers;

use App\Mail\LoanApplicationSubmittedMail;
use App\Mail\NewMemberWelcomeMail;
use App\Models\Contribution;
use App\Models\Loan;
use App\Models\LoanType;
use App\Models\Member;
use App\Models\OpeningBalance;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd('pal');
        $user = Auth::user();
        $member = $user->member ?? Member::where('staff_no', $user->staff_no)->first();

        $stats = [
            'personal_contributions' => Contribution::whereHas('member', function ($q) use ($user) {
                $q->where('staff_no', $user->staff_no);
            })->sum('contribution_amount') ?: 0,
            // 'interest_earned' => 0, // Add InterestEarning model if exists
            'current_balance' => OpeningBalance::whereHas('member', function ($q) use ($user) {
                $q->where('staff_no', $user->staff_no);
            })->sum('amount'),
            'active_loans' => Loan::whereHas('member', function ($q) use ($user) {
                $q->where('staff_no', $user->staff_no);
            })->where('status', 'approved')->sum('outstanding_balance') ?: 0,
        ];
        // dd($stats);

        return view('members.dashboard', compact('member', 'stats'));
    }

    public function loanApplication()
    {
        $loanTypes = LoanType::all();
        // check if staff is a member
        $staffmember = Member::where('staff_no', Auth::user()->staff_no)->first();

        // if(!$staffmember){
        //     return redirect()->route('membership-form')->with('error', 'You must be a member to apply for a loan. Please fill the membership form first.');
        // }
        return view('members.loan-application', compact('loanTypes', 'staffmember'));
    }

    /**
     * Display withdrawal request form.
     */
    public function withdrawalRequest()
    {
        $member = Auth::user()->member; // Assume relationship

        return view('members.withdrawal-request', compact('member'));
    }

    /**
     * Store withdrawal request.
     */
    public function storeWithdrawal(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:500',
            'reason' => 'required|in:retirement,housing,education,medical,emigration',
            'notes' => 'nullable|string|max:1000',
        ]);

        Withdrawal::create($request->only('amount', 'reason', 'notes'));

        return redirect()->route('withdrawal-request')->with('success', 'Withdrawal request submitted successfully.');
    }

    /**
     * Store loan application.
     */
    public function storeLoan(Request $request)
    {
        dd($request->all());
        $request->validate([
            'loan_type' => 'required',
            'amount' => 'required|numeric|min:1000|max:50000',
            'term_months' => 'required|integer|min:6|max:48',
            'purpose' => 'required|string|max:1000',
            'doc_id' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_payslip' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_letter' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_bank' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $loanType = LoanType::findOrFail($request->loan_type_id);
        $monthly = $this->calcPMT($request->amount, $loanType->interest_rate, $request->term_months);
        $totalRepay = $monthly * $request->term_months;

        $loanData = [
            'member_id' => Auth::user()->member->id,
            'loan_type' => $request->loan_type_id,
            'amount' => $request->amount,
            'interest_rate' => $loanType->interest_rate,
            'term_months' => $request->term_months,
            'monthly_payment' => $monthly,
            'total_repayable' => $totalRepay,
            'outstanding_balance' => $totalRepay,
            'status' => 'pending',
            'purpose' => $request->purpose,
        ];

        $loan = Loan::create($loanData);

        // Store documents
        foreach (['doc_id', 'doc_payslip', 'doc_letter', 'doc_bank', 'doc_purpose', 'doc_other'] as $doc) {
            if ($request->hasFile($doc)) {
                $path = $request->file($doc)->store('loan-docs/'.$loan->id, 'public');
                // Save path to loan or separate table
            }
        }

        // Send confirmation email
        Mail::to(Auth::user()->email)->send(new LoanApplicationSubmittedMail($loan));

        return redirect()->route('loan-application')->with('success', 'Loan application submitted! Ref: '.$loan->application_ref.' Confirmation email sent.');
    }

    private function calcPMT($principal, $annualRate, $months)
    {
        $r = ($annualRate / 100) / 12;
        if ($r == 0) {
            return $principal / $months;
        }

        return $principal * $r * pow(1 + $r, $months) / (pow(1 + $r, $months) - 1);
    }

    public function membershipform()
    {
        // where status is active
        // $members = Member::where('status', 'active')->get();
        // get authenticated user
        $members = DB::table('hr.staff as t1')->leftJoin('hr.promotion as t4', 't1.staff_no', '=', 't4.staff_no')->leftJoin('hr.unit as t3', 't4.unit_id', '=', 't3.id')->leftJoin('hr.job as t5', 't4.job_id', '=', 't5.id')->leftJoin('provident_fund.users as t2', 't1.staff_no', '=', 't2.staff_no')->select('t1.*', 't3.long_name as department', 't5.title as job_title')->where('t1.staff_no', Auth::user()->staff_no)->get();

        // dd($members);
        return view('members.membership-form', compact('members'));
    }

    public function membershipform_admin()
    {
        // where status is active
        $members = Member::where('status', 'active')->get();
        // get authenticated user
        // $members = DB::table('hr.staff as t1')->leftJoin('hr.promotion as t4', 't1.staff_no', '=', 't4.staff_no')->leftJoin('hr.unit as t3', 't4.unit_id', '=', 't3.id')->leftJoin('hr.job as t5', 't4.job_id', '=', 't5.id')->leftJoin('provident_fund.users as t2', 't1.staff_no', '=', 't2.staff_no')->select('t1.*', 't3.long_name as department', 't5.title as job_title')->where('t1.staff_no', Auth::user()->staff_no)->get();

        // generate staff for members who are not staff in the in the university but are members of the provident fund
        $generatestaffno = 'PRU-'.str_pad(Member::max('id') + 1, 5, '0', STR_PAD_LEFT);

        // dd($members);
        return view('admin.membership-form-admin', compact('members', 'generatestaffno'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $staff_no = $request->input('staff_no');
        //     $member = Member::where('staff_no', $staff_no)->first();

        //     if ($member) {
        //         return redirect()->route('membership-form')->with('error', 'You have already created an account.');
        //     }

        try {
            $request->validate([
                'staff_no' => 'required|string|max:50|unique:members,staff_no',
                'bank_name' => 'required|string|max:100',
                'account_number' => 'required|string|max:50',
                'account_name' => 'required|string|max:255',
                'monthly_contribution' => 'required|numeric|min:1',
                'next_of_kin_name' => 'required|string|max:255',
                'next_of_kin_relationship' => 'required|string|max:100',
                'next_of_kin_phone' => 'required|string|max:20',
                'next_of_kin_email' => 'required|email|max:255',
                'next_of_kin_address' => 'required|string|max:255',
                'signed_agreement' => 'accepted',
            ]);

            // Create a new member
            $member = Member::create([
                'staff_no' => $request->input('staff_no'),
                // 'email' => $request->input('email'),
                // 'phone_number' => $request->input('phone_number'),
                // 'date_of_birth' => $request->input('date_of_birth'),
                'bank_name' => $request->input('bank_name'),
                'account_number' => $request->input('account_number'),
                'account_name' => $request->input('account_name'),
                'monthly_contribution' => $request->input('monthly_contribution'),
                // 'total_contribution' => $request->input('total_contribution'),
                'next_of_kin_name' => $request->input('next_of_kin_name'),
                'next_of_kin_relationship' => $request->input('next_of_kin_relationship'),
                'next_of_kin_phone' => $request->input('next_of_kin_phone'),
                'next_of_kin_email' => $request->input('next_of_kin_email'),
                'next_of_kin_address' => $request->input('next_of_kin_address'),
                'signed_agreement' => true,
            ]);
            // dd($request->all());
            // $member = Member::create($request->all());
            if ($member) {
                // Redirect to a success page or back with a success message
                // dd('Member created successfully.');
                return redirect()->route('membership-form')->with('success', 'Member created successfully.');
            } else {
                // dd('Member not created successfully.');
                return redirect()->route('membership-form')->with('error', 'Member not created successfully.');
            }
        } catch (ValidationException $e) {
            // Handle validation errors
            Log::error('Error: '.$e->getMessage());

            return redirect()->route('membership-form')->withErrors($e->validator)->withInput();
        }

        // Redirect to a success page or back with a success message
        // return redirect()->route('staff.membership-form')->with('success', 'Member created successfully.');
    }

    public function store_admin(Request $request)
    {
        try {
            $request->validate([
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'mname' => 'nullable|string|max:255',
                'staff_no' => 'required|string|max:50|unique:members,staff_no',
                'phone_no' => 'required|string|max:20|unique:users,phone_no',
                'email' => 'required|email|max:255|unique:users,email',
                'date_of_birth' => 'required|date',
                'company' => 'required|string|max:255',
                'job_title' => 'required|string|max:255',
                'date_of_employment' => 'required|date',
                'bank_name' => 'required|string|max:100',
                'account_number' => 'required|string|max:50',
                'account_name' => 'required|string|max:255',
                'monthly_contribution' => 'required|numeric|min:1',
                'next_of_kin_name' => 'required|string|max:255',
                'next_of_kin_relationship' => 'required|string|max:100',
                'next_of_kin_phone' => 'required|string|max:20',
                'next_of_kin_email' => 'required|email|max:255',
                'next_of_kin_address' => 'required|string|max:255',
                'signed_agreement' => 'accepted',
            ]);

            $member = Member::create([
                'staff_no' => $request->input('staff_no'),
                'bank_name' => $request->input('bank_name'),
                'account_number' => $request->input('account_number'),
                'account_name' => $request->input('account_name'),
                'monthly_contribution' => $request->input('monthly_contribution'),
                'next_of_kin_name' => $request->input('next_of_kin_name'),
                'next_of_kin_relationship' => $request->input('next_of_kin_relationship'),
                'next_of_kin_phone' => $request->input('next_of_kin_phone'),
                'next_of_kin_email' => $request->input('next_of_kin_email'),
                'next_of_kin_address' => $request->input('next_of_kin_address'),
                'signed_agreement' => true,
            ]);

            $generaterandompassword = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 8);

            $createuser = User::create([
                'fname' => $request->input('fname'),
                'lname' => $request->input('lname'),
                'mname' => $request->input('mname'),
                'email' => $request->input('email'),
                'phone_no' => $request->input('phone_no'),
                'date_of_birth' => $request->input('date_of_birth'),
                'company' => $request->input('company'),
                'job_title' => $request->input('job_title'),
                'staff_no' => $request->input('staff_no'),
                'password' => bcrypt($generaterandompassword), // Default password, should be changed by user
            ]);
            // send email to user with login details with the generated raw password
            Mail::to($createuser->email)->send(new NewMemberWelcomeMail($createuser, $generaterandompassword));
            // Mail::to($createuser->email)->send(new NewMemberWelcomeMail($createuser));

            if ($member) {
                return redirect()->route('admin.membership-form-admin')->with('success', 'Member created successfully and login credentials sent via email.');
            } else {
                return redirect()->route('admin.membership-form-admin')->with('error', 'Member not created successfully.');
            }
        } catch (ValidationException $e) {
            Log::error('Error: '.$e->getMessage());

            return redirect()->route('admin.membership-form-admin')->withErrors($e->validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // show one member details where status is active
        // $member = Member::find($id)->where('status', 'active')->first();
        // return view('admin.members.show', compact('member'));

        $getstaff = DB::table('hr.staff')->leftJoin('members', 'hr.staff.staff_no', '=', 'members.staff_no')
            ->where('members.staff_no', $id)->where('status', 'active')->first();
        $getstaff = DB::table('hr.staff')->leftJoin('members', 'hr.staff.staff_no', '=', 'members.staff_no')
            ->where('members.staff_no', $id)->where('status', 'active')->first();
        $member = $getstaff;

        return view('admin.show', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update member details where status is active
        $member = Member::find($id)->where('status', 'active')->first();
        $member->update($request->all());

        return redirect()->route('admin.index')->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delete member by updating status to inactive
        $member = Member::find($id);
        $member->status = 'inactive';
        $member->save();

        return redirect()->route('admin.index')->with('success', 'Member deleted successfully.');
    }
}
