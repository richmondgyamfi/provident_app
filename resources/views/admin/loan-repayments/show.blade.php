@extends('layouts.app')

@section('title', 'Upload Details - {{ $loanRepaymentUpload->filename }}')

@section('content')
<div class="p-6">
    <div class="flex items-start gap-4 mb-8">
        <a href="{{ route('admin.loan-repayment-uploads.index') }}" class="text-slate-500 hover:text-slate-900">
            <span class="material-symbols-outlined mr-1">arrow_back</span> Back to Uploads
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-2">{{ $loanRepaymentUpload->filename }}</h2>
                <div class="flex items-center gap-2 mb-4">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-{{ $statusClass }}-100 text-{{ $statusClass }}-800 dark:bg-{{ $statusClass }}-900 dark:text-{{ $statusClass }}-200">
                        {{ ucfirst($loanRepaymentUpload->status) }}
                    </span>
                    <span class="material-symbols-outlined text-green-500 text-xl">check_circle</span>
                </div>
                <p class="text-slate-600 dark:text-slate-400 mb-4"><span class="font-bold">Records:</span> {{ $loanRepaymentUpload->records_count }}</p>
                <p class="text-slate-600 dark:text-slate-400 mb-6"><span class="font-bold">Uploaded:</span> {{ $loanRepaymentUpload->created_at->format('M d, Y H:i') }} by {{ $loanRepaymentUpload->user->name ?? 'Admin' }}</p>
                @if ($loanRepaymentUpload->notes)
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-3">
                        <p class="text-xs text-amber-800">{{ $loanRepaymentUpload->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-2">Imported Repayments ({{ $repayments->count() }})</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-900 dark:text-slate-100 uppercase">Staff</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-900 dark:text-slate-100 uppercase">Loan Ref</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-slate-900 dark:text-slate-100 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-900 dark:text-slate-100 uppercase">Installment</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-900 dark:text-slate-100 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-900 dark:text-slate-100 uppercase">Method</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            @forelse ($repayments as $repayment)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900 dark:text-slate-100">{{ $repayment->loan->member->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $repayment->loan->member->staff_no }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-mono text-sm font-bold">#{{ $repayment->loan->application_ref }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="font-black text-xl text-primary">₵{{ number_format($repayment->amount, 2) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    #{{ $repayment->installment_number }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500">{{ $repayment->payment_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-slate-100 text-xs rounded-full dark:bg-slate-800">{{ ucwords(str_replace('_', ' ', $repayment->payment_method)) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    No repayments found for this upload.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

