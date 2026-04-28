<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\LoanRepayment;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['user', 'loanType'])->latest()->paginate(20);
        // dd($loans);
        return view('admin.loans.index', compact('loans'));
    }

    public function show(Loan $loan)
    {
        $loan->load(['user', 'loanType', 'repayments']);
        return view('admin.loans.show', compact('loan'));
    }

    public function approve(Loan $loan, Request $request)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'approved_amount' => 'required_if:status,approved|numeric|min:1000',
            'notes' => 'nullable|string|max:1000',
        ]);

        $loan->update([
            'status' => $request->status,
            'approved_amount' => $request->status === 'approved' ? $request->approved_amount : $loan->amount,
            'approved_by' => Auth::id(),
            'notes' => $request->notes,
        ]);

        if ($request->status === 'approved') {
            $loan->disbursed_at = now();
            $loan->save();
        }

        return redirect()->route('admin.loans.show', $loan)->with('success', 'Loan ' . strtolower($request->status) . ' successfully.');
    }

    // Repayments
    public function createRepayment(Loan $loan)
    {
        return view('admin.loan-repayments.create', compact('loan'));
    }

    public function storeRepayment(Request $request, Loan $loan)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0|max:' . $loan->monthly_payment * 2,
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:50',
            'reference' => 'nullable|string|max:100',
        ]);

        LoanRepayment::create([
            'loan_id' => $loan->id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'reference' => $request->reference,
            'recorded_by' => Auth::id(),
        ]);

        return redirect()->route('admin.loans.show', $loan)->with('success', 'Repayment recorded.');
    }
}
