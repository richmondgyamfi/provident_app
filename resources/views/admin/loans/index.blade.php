@extends('layouts.app')

@section('title', 'Loan Applications')

@section('content')
<div class="p-4 sm:p-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-slate-100">Loan Applications</h1>
            <p class="text-slate-500 dark:text-slate-400">Manage pending loan requests and repayments</p>
        </div>
        <div class="flex gap-3">
            <select class="px-4 h-11 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm">
                <option>All Statuses</option>
            </select>
            <a href="{{ route('admin.loans.index') }}" class="px-6 h-11 bg-primary text-white rounded-lg font-bold hover:bg-primary/90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">refresh</span>
                Refresh
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Applicant</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Term</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Applied</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($loans as $loan)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                                    {{ substr($loan->user->fname .' '.$loan->user->mname.' '.$loan->user->lname ?? 'N/A', 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900 dark:text-slate-100">{{ $loan->user->fname .' '.$loan->user->mname.' '.$loan->user->lname ?? 'N/A' }}</p>
                                    <p class="text-xs text-slate-500">{{ $loan->user->staff_no }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900 dark:text-slate-100">₵{{ number_format($loan->amount, 2) }}</p>
                            <p class="text-xs text-slate-500">Monthly: ₵{{ number_format($loan->monthly_payment, 2) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-900 dark:text-slate-100">{{ $loan->loanType->name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900 dark:text-slate-100">{{ $loan->term_months }} months</p>
                        </td>
                        <td class="px-6 py-4">
                            @php $statusClass = $loan->getStatusColorAttribute(); @endphp
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-{{ $statusClass }}-100 text-{{ $statusClass }}-700 dark:bg-{{ $statusClass }}-900/50 dark:text-{{ $statusClass }}-300">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-900 dark:text-slate-100">{{ $loan->created_at->format('M d, Y') }}</p>
                            <p class="text-xs text-slate-500">{{ $loan->created_at->diffForHumans() }}</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.loans.show', $loan) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                            <span class="material-symbols-outlined text-6xl block mb-4 opacity-25">payments</span>
                            No loan applications
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200 dark:border-slate-800">
            {{ $loans->links() }}
        </div>
    </div>
</div>
@endsection
