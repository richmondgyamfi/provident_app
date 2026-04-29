@extends('layouts.app')

@section('title', 'Record Repayment')

@section('content')
<div class="p-4 sm:p-8 max-w-2xl mx-auto">
    <div class="flex items-start gap-4 mb-8">
        <a href="{{ route('admin.loans.show', $loan) }}" class="text-slate-500 hover:text-slate-900">
            <span class="material-symbols-outlined mr-1">arrow_back</span> Back to Loan
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-8">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-6">Record Repayment</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Loan #{{ $loan->application_ref }}</p>
                <p class="text-xl font-black text-slate-900 dark:text-slate-100">₵{{ number_format($loan->amount, 2) }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Monthly Payment</p>
                <p class="text-xl font-bold text-primary">₵{{ number_format($loan->monthly_payment, 2) }}</p>
            </div>
        </div>

        <form action="{{ route('admin.loans.repayment.store', $loan) }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Payment Amount</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">₵</span>
                        <input type="number" step="0.01" name="amount" required 
                            value="{{ $loan->monthly_payment }}" 
                            class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:border-primary/30 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 dark:placeholder-slate-400" />
                            {{-- w-full px-4 py-3 rounded-lg border border-primary/20 dark:border-primary/30 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-500 dark:placeholder-slate-400 --}}
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Total paid so far: ₵{{ number_format($loan->repayments->sum('amount'), 2) }}</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Payment Date</label>
                    <input type="date" name="payment_date" required value="{{ date('Y-m-d') }}" 
                        class="w-full px-4 py-3 rounded-lg border border-primary/20 dark:border-primary/30 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-500 dark:placeholder-slate-400" />
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Payment Method</label>
                    <select name="payment_method" required class="w-full px-4 py-3 rounded-lg border border-primary/20 dark:border-primary/30 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-500 dark:placeholder-slate-400">
                        <option value="salary_deduction">Salary Deduction</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="cash">Cash Deposit</option>
                        <option value="cheque">Cheque</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Reference / Receipt #</label>
                    <input type="text" name="reference" class="w-full px-4 py-3 rounded-lg border border-primary/20 dark:border-primary/30 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-500 dark:placeholder-slate-400" placeholder="e.g. REF-2024-001" />
                </div>
            </div>

            <div class="flex gap-3 pt-8 border-t mt-8">
                <a href="{{ route('admin.loans.show', $loan) }}" class="flex-1 py-3 px-6 border border-slate-300 text-slate-700 rounded-lg font-bold text-center hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="flex-1 py-3 px-6 bg-primary text-white rounded-lg font-bold hover:bg-primary/90 transition-colors shadow-lg">
                    Record Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
