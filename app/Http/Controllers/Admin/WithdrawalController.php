<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with('member')->latest()->paginate(20);

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function show(Withdrawal $withdrawal)
    {
        $withdrawal->load('member');

        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    public function updateStatus(Request $request, Withdrawal $withdrawal)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,paid',
            'notes' => 'nullable|string|max:1000',
            'approved_amount' => 'required_if:status,approved,paid|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $withdrawal) {
            $approvedAmount = $request->approved_amount ?? $withdrawal->amount;

            // If approving or marking as paid, check balance and reduce contributions
            if (in_array($request->status, ['approved', 'paid'])) {
                // Calculate available balance
                $totalContributions = Contribution::where('member_id', $withdrawal->member_id)->sum('contribution_amount');
                $totalPreviousWithdrawals = Withdrawal::where('member_id', $withdrawal->member_id)
                    ->where('status', 'paid')
                    ->where('id', '!=', $withdrawal->id)
                    ->sum('approved_amount');
                $availableBalance = $totalContributions - $totalPreviousWithdrawals;

                if ($approvedAmount > $availableBalance) {
                    throw new \Exception('Insufficient balance. Available: ₵'.number_format($availableBalance, 2));
                }

                // For approved status, we just validate the amount
                // For paid status, we actually reduce the contributions by creating a negative contribution record
                if ($request->status === 'paid') {
                    // Create a negative contribution record to represent the withdrawal
                    Contribution::create([
                        'member_id' => $withdrawal->member_id,
                        'staff_no' => $withdrawal->member->staff_no,
                        'contribution_amount' => -$approvedAmount,
                        'contribution_type' => 'withdrawal',
                        'payment_reference' => 'WD-'.$withdrawal->id,
                        'notes' => 'Withdrawal payment - '.ucfirst($withdrawal->reason),
                        'source' => 'withdrawal',
                        'status' => 'active',
                        'uploaded_by' => auth()->id(),
                        'payroll_month' => now()->format('m'),
                        'payroll_year' => now()->format('Y'),
                    ]);
                }
            }

            $withdrawal->update([
                'status' => $request->status,
                'notes' => $request->notes,
                'processed_by' => auth()->id(),
                'processed_at' => now(),
                'approved_amount' => $approvedAmount,
            ]);
        });

        return redirect()->back()->with('success', 'Withdrawal '.$request->status.' successfully.');
    }
}
