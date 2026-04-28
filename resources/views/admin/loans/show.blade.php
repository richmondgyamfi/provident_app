@extends('layouts.app')

@section('title', 'Loan Details')

@section('content')
<div class="p-4 sm:p-8 space-y-6">
    <div class="flex flex-wrap justify-between items-start gap-4 mb-8">
        <div class="flex flex-col gap-2">
            <h1 class="text-3xl font-black text-slate-900 dark:text-slate-100">Loan Application #{{ $loan->application_ref }}</h1>
            <div class="flex flex-wrap gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30">Pending</span>
            </div>
        </div>
        <div class="flex gap-3">
            @if($loan->status === 'pending')
            <form action="{{ route('admin.loans.approve', $loan) }}" method="POST" class="inline">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="approved">
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700">Approve</button>
            </form>
            <form action="{{ route('admin.loans.approve', $loan) }}" method="POST" class="inline">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="rejected">
                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700">Reject</button>
            </form>
            @endif
            <a href="{{ route('admin.loans.index') }}" class="px-6 py-2 bg-slate-200 text-slate-700 rounded-lg font-bold hover:bg-slate-300">← Back</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Application Details -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 space-y-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100">Application Details</h2>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Applicant</p>
                    <p class="font-bold text-slate-900 dark:text-slate-100">{{ $loan->user->name }}</p>
                    <p class="text-sm text-slate-500">{{ $loan->user->staff_no }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Loan Type</p>
                    <p class="font-bold text-slate-900 dark:text-slate-100">{{ $loan->loanType->name }}</p>
                    <p class="text-sm text-slate-500">{{ $loan->loanType->description }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Requested Amount</p>
                    <p class="text-2xl font-black text-slate-900 dark:text-slate-100">₵{{ number_format($loan->amount, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Monthly Payment</p>
                    <p class="text-xl font-bold text-primary">₵{{ number_format($loan->monthly_payment, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Term</p>
                    <p class="font-bold text-slate-900 dark:text-slate-100">{{ $loan->term_months }} months</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Interest Rate</p>
                    <p class="font-bold text-slate-900 dark:text-slate-100">{{ $loan->interest_rate }}% p.a.</p>
                </div>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Purpose</p>
                <p class="text-slate-700 dark:text-slate-300">{{ $loan->purpose }}</p>
            </div>
            @if($loan->notes)
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Admin Notes</p>
                <p class="text-slate-700 dark:text-slate-300">{{ $loan->notes }}</p>
            </div>
            @endif
        </div>

        <!-- Repayments -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 space-y-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">Repayments</h2>
            @if($loan->repayments->count())
            <div class="space-y-3">
                @foreach($loan->repayments->take(5) as $repayment)
                <div class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg">
                    <div class="size-12 bg-primary/10 rounded-lg flex items-center justify-center text-primary">
                        ₵{{ number_format($repayment->amount, 2) }}
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-slate-900 dark:text-slate-100">{{ $repayment->payment_date->format('M d, Y') }}</p>
                        <p class="text-sm text-slate-500">{{ $repayment->payment_method }} - {{ $repayment->reference ?? 'N/A' }}</p>
                    </div>
                    <p class="font-bold text-slate-900 dark:text-slate-100">Total Paid: ₵{{ number_format($loan->repayments->sum('amount'), 2) }}</p>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 text-slate-500">
                <span class="material-symbols-outlined text-4xl block mb-2 opacity-50">payments</span>
                No repayments recorded
            </div>
            @endif
            <a href="{{ route('admin.loans.repayment.create', $loan) }}" class="w-full py-3 bg-primary text-white rounded-lg font-bold hover:bg-primary/90 text-center block">
                Record Repayment
            </a>
        </div>
    </div>
</div>
@endsection
