<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

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

        $withdrawal->update([
            'status' => $request->status,
            'notes' => $request->notes,
'processed_by' => auth()->id(),
            'processed_at' => now(),
            'amount' => $request->approved_amount ?? $withdrawal->amount, // Adjust if partial
        ]);

        return redirect()->back()->with('success', 'Withdrawal ' . $request->status . ' successfully.');
    }
}
