@extends('layouts.app')

@section('title', $member->name)

@section('content')
    <div class="py-8 space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.members.index') }}" class="p-2 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-slate-500">arrow_back</span>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 dark:text-white">{{ $member->name }}</h1>
                    <p class="text-slate-500 mt-1">Staff No: {{ $member->staff_no }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-xs text-slate-400 uppercase tracking-widest">Member Since</p>
                <p class="font-bold text-slate-900 dark:text-white">{{ $member->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <!-- Profile Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Bank Details -->
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6">
                <h3 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-4">Bank Details</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-slate-400">Bank Name</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $member->bank_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Account Number</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $member->account_number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Account Name</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $member->account_name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Next of Kin -->
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6">
                <h3 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-4">Next of Kin</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-slate-400">Name</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $member->next_of_kin_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Relationship</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $member->next_of_kin_relationship ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Phone</p>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $member->next_of_kin_phone ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Contribution Summary -->
            <div class="bg-primary text-white rounded-xl p-6">
                <h3 class="text-xs font-bold uppercase tracking-widest text-white/70 mb-4">Contribution Summary</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-white/70">Monthly Contribution</p>
                        <p class="font-black text-2xl">{{ number_format($member->monthly_contribution ?? 0, 2) }} % of basic</p>
                    </div>
                    <div class="pt-3 border-t border-white/20">
                        <p class="text-xs text-white/70">Total Contributions</p>
                        <p class="font-bold text-lg">GHS {{ number_format($totalContributions, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contributions Table -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Contribution History</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                            <th class="px-6 py-3 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">Period</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">Basic Salary</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">Employee</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">Employer</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">Total</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($member->contributions as $contribution)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30">
                                <td class="px-6 py-4 text-sm text-slate-900 dark:text-white font-medium">
                                    {{ \App\Models\Contribution::getMonthName($contribution->payroll_month) }} {{ $contribution->payroll_year }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">GHS {{ number_format($contribution->basic_salary ?? 0, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">GHS {{ number_format($contribution->employee_amount ?? 0, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">GHS {{ number_format($contribution->employer_amount ?? 0, 2) }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-white">GHS {{ number_format($contribution->contribution_amount ?? 0, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-1 rounded text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                                        {{ ucfirst($contribution->status ?? 'Active') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    No contribution records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Totals -->
        @if($member->contributions->count() > 0)
        <div class="flex justify-end">
            <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-6 w-full md:w-1/3">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Total Employee Contributions</span>
                        <span class="font-bold text-slate-900 dark:text-white">GHS {{ number_format($totalEmployee, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Total Employer Contributions</span>
                        <span class="font-bold text-slate-900 dark:text-white">GHS {{ number_format($totalEmployer, 2) }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-slate-200 dark:border-slate-700">
                        <span class="font-bold text-slate-900 dark:text-white">Grand Total</span>
                        <span class="font-black text-primary">GHS {{ number_format($totalContributions, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
