@extends('layouts.app')

@section('title', 'Member Dashboard')

@section('content')
    <div class="lp-4 sm:p-8 space-y-6 sm:space-y-8">
        <!-- Welcome Header -->
        <div class="flex flex-wrap justify-between items-end gap-3 mb-8">
            <div class="flex flex-col gap-1">
                <p class="text-slate-900 dark:text-slate-100 text-3xl font-black leading-tight tracking-tight">Member
                    Dashboard</p>
                <p class="text-slate-500 dark:text-slate-400 text-base font-normal">Welcome back, John. Here's a snapshot of
                    your provident fund performance.</p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-lg p-2 border border-slate-200 dark:border-slate-700 flex gap-2">
                <button
                    class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg flex items-center gap-2 shadow-lg shadow-primary/20 hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined text-sm">download</span>
                    Annual Report
                </button>
            </div>
        </div>
        <!-- My Fund Summary Cards -->
        <h2 class="text-slate-900 dark:text-slate-100 text-xl font-bold mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">analytics</span>
            My Fund Summary
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mb-8">
            <div
                class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow border-l-4 border-l-primary">
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium uppercase tracking-wider">Personal
                    Contributions</p>
                {{ number_format($stats['personal_contributions'], 2) }}
                <div class="flex items-center gap-1 text-emerald-600 text-sm font-bold">
                    <span class="material-symbols-outlined text-sm">trending_up</span>
                    <span>+5.2%</span>
                    <span class="text-slate-400 font-normal ml-1">vs last yr</span>
                </div>
            </div>
            {{-- <div
                class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow border-l-4 border-l-accent-gold">
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium uppercase tracking-wider">Interest Earned
                </p>
                {{ number_format($stats['interest_earned'], 2) }}
                <div class="flex items-center gap-1 text-emerald-600 text-sm font-bold">
                    <span class="material-symbols-outlined text-sm">trending_up</span>
                    <span>+3.1%</span>
                    <span class="text-slate-400 font-normal ml-1">YTD</span>
                </div>
            </div> --}}
            <div
                class="flex flex-col gap-2 rounded-xl p-6 bg-primary text-white border border-primary shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform">
                <p class="text-white/80 text-sm font-medium uppercase tracking-wider">All Contribution</p>
                {{ number_format($stats['current_balance'], 2) }}
                <div class="flex items-center gap-1 text-accent-gold text-sm font-bold">
                    <span class="material-symbols-outlined text-sm">verified</span>
                    <span>Verified</span>
                </div>
            </div>
            <div
                class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow border-l-4 border-l-accent-red">
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium uppercase tracking-wider">Active Loan
                    Balance</p>
                {{ number_format($stats['active_loans'], 2) }}
                <div class="flex items-center gap-1 text-rose-500 text-sm font-bold">
                    <span class="material-symbols-outlined text-sm">history</span>
                    <span>-10.5%</span>
                    <span class="text-slate-400 font-normal ml-1">Paid off</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Quick Actions -->
            <div class="lg:col-span-1">
                <h2 class="text-slate-900 dark:text-slate-100 text-xl font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">bolt</span>
                    Quick Actions
                </h2>
                <div class="flex flex-col gap-3">
                    <a href={{ route('loan-application') }}
                        class="flex items-center justify-between w-full p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary group transition-all">
                        <div class="flex items-center gap-4">
                            <div
                                class="size-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined">request_quote</span>
                            </div>
                            <div class="text-left">
                                <p class="font-bold text-slate-900 dark:text-slate-100">Apply for Loan</p>
                                <p class="text-xs text-slate-500">Up to 70% of balance</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">chevron_right</span>
                    </a>
                    <a href="{{ route('withdrawal-request') }}"
                        class="flex items-center justify-between w-full p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-accent-red group transition-all">
                        <div class="flex items-center gap-4">
                            <div
                                class="size-10 rounded-lg bg-accent-red/10 flex items-center justify-center text-accent-red group-hover:bg-accent-red group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined">outbox</span>
                            </div>
                            <div class="text-left">
                                <p class="font-bold text-slate-900 dark:text-slate-100">Request Withdrawal</p>
                                <p class="text-xs text-slate-500">Partial or full options</p>
                            </div>
                        </div>
                        <span
                            class="material-symbols-outlined text-slate-400 group-hover:text-accent-red">chevron_right</span>
                    </a>
                    <a href="{{ route('staff-statement') }}"
                        class="flex items-center justify-between w-full p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-accent-gold group transition-all">
                        <div class="flex items-center gap-4">
                            <div
                                class="size-10 rounded-lg bg-accent-gold/10 flex items-center justify-center text-accent-gold group-hover:bg-accent-gold group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined">receipt_long</span>
                            </div>
                            <div class="text-left">
                                <p class="font-bold text-slate-900 dark:text-slate-100">Download Statement</p>
                                <p class="text-xs text-slate-500">Available in PDF/Excel</p>
                            </div>
                        </div>
                        <span
                            class="material-symbols-outlined text-slate-400 group-hover:text-accent-gold">chevron_right</span>
                    </a>
                    <div
                        class="mt-4 p-4 rounded-xl bg-slate-900 dark:bg-primary/20 text-white relative overflow-hidden border-t-2 border-accent-gold">
                        <div class="relative z-10">
                            <p class="text-xs font-bold uppercase tracking-widest text-accent-gold mb-1">Financial Tip</p>
                            <p class="text-sm font-medium">Increasing your voluntary contribution by just 2% can
                                significantly boost your retirement fund.</p>
                        </div>
                        <span
                            class="material-symbols-outlined absolute -right-4 -bottom-4 text-7xl text-white/5 rotate-12">lightbulb</span>
                    </div>
                </div>
            </div>
            <!-- Contribution History -->
            <div class="lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-slate-900 dark:text-slate-100 text-xl font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">history</span>
                        Contribution History
                    </h2>
                    <a class="text-primary text-sm font-bold hover:underline" href="#">View All</a>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                                    <th
                                        class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">
                                        Type</th>
                                    <th
                                        class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider text-right">
                                        Amount</th>
                                    <th
                                        class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4 text-sm text-slate-900 dark:text-slate-100 font-medium">Oct 15,
                                        2023</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm text-slate-900 dark:text-slate-100 font-semibold">Monthly
                                                Contribution</span>
                                            <span class="text-[10px] text-slate-400 uppercase font-bold">Employer +
                                                Employee</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-slate-100 text-right">
                                        GHS 0</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">Completed</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4 text-sm text-slate-900 dark:text-slate-100 font-medium">Sep 15,
                                        2023</td>
                                    <td class="px-6 py-4 text-sm text-slate-900 dark:text-slate-100 font-semibold">Monthly
                                        Contribution</td>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-slate-100 text-right">
                                        GHS 0</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">Completed</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4 text-sm text-slate-900 dark:text-slate-100 font-medium">Aug 30,
                                        2023</td>
                                    <td class="px-6 py-4 text-sm text-slate-900 dark:text-slate-100 font-semibold">Voluntary
                                        Top-up</td>
                                    <td
                                        class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-slate-100 text-right text-accent-red">
                                        GHS 0</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">Completed</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4 text-sm text-slate-900 dark:text-slate-100 font-medium">Aug 15,
                                        2023</td>
                                    <td class="px-6 py-4 text-sm text-slate-900 dark:text-slate-100 font-semibold">Monthly
                                        Contribution</td>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-slate-100 text-right">
                                        GHS 0</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">Completed</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4 text-sm text-slate-900 dark:text-slate-100 font-medium">Jul 15,
                                        2023</td>
                                    <td class="px-6 py-4 text-sm text-slate-900 dark:text-slate-100 font-semibold">Monthly
                                        Contribution</td>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-slate-100 text-right">
                                        GHS 0</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">Completed</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
