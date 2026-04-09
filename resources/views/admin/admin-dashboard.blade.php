@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Page content -->
    <div class="p-4 sm:p-8 space-y-6 sm:space-y-8">

        <!-- ── KPI Cards ──────────────────────────────────────────── -->
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-3 sm:gap-4">

            <div
                class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-slate-500 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2">Total Members
                </p>
                <div class="flex items-end justify-between">
<h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">{{ number_format($stats['members_count']) }}</h3>
                    <span class="text-emerald-500 text-xs font-bold flex items-center gap-0.5">
                        +2.4%
                        <span class="material-symbols-outlined text-sm">trending_up</span>
                    </span>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-slate-500 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2">Total
                    Contributions</p>
                <div class="flex items-end justify-between">
<h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">$ {{ number_format($stats['total_contributions'] / 1000000, 1) }}M</h3>
                    <span class="text-accent-red text-xs font-bold flex items-center gap-0.5">
                        -1.2%
                        <span class="material-symbols-outlined text-sm">trending_down</span>
                    </span>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-slate-500 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2">Loans Issued
                </p>
                <div class="flex items-end justify-between">
<h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">$ {{ number_format($stats['loans_issued'] / 1000000, 1) }}M</h3>
                    <span class="text-emerald-500 text-xs font-bold flex items-center gap-0.5">
                        +5.6%
                        <span class="material-symbols-outlined text-sm">trending_up</span>
                    </span>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-slate-500 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2">Repayments</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">$8.4M</h3>
                    <span class="text-emerald-500 text-xs font-bold flex items-center gap-0.5">
                        +3.1%
                        <span class="material-symbols-outlined text-sm">trending_up</span>
                    </span>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-slate-500 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2">Withdrawals</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">$5.1M</h3>
                    <span class="text-accent-red text-xs font-bold flex items-center gap-0.5">
                        -0.5%
                        <span class="material-symbols-outlined text-sm">trending_down</span>
                    </span>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm ring-2 ring-primary ring-opacity-10">
                <p class="text-slate-500 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2">Fund Balance
                </p>
                <div class="flex items-end justify-between">
                    <h3 class="text-xl sm:text-2xl font-bold text-primary">$30.1M</h3>
                    <span class="text-emerald-500 text-xs font-bold flex items-center gap-0.5">
                        +4.2%
                        <span class="material-symbols-outlined text-sm">trending_up</span>
                    </span>
                </div>
            </div>

        </div>

        <!-- ── Chart + Asset Distribution ─────────────────────────── -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 sm:gap-8">

            <!-- Contribution Trends Chart -->
            <div
                class="xl:col-span-2 bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-8">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Contribution Trends</h3>
                        <p class="text-sm text-slate-500">Overview of the last 6 months performance</p>
                    </div>
                    <select
                        class="bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-xs font-bold focus:ring-primary focus:border-primary">
                        <option>Last 6 Months</option>
                        <option>Last Year</option>
                    </select>
                </div>

                <div class="h-[260px] sm:h-[300px] w-full relative">
                    <!-- Grid lines -->
                    <div class="absolute inset-0 flex flex-col justify-between pt-2">
                        <div class="border-t border-slate-100 dark:border-slate-800 w-full"></div>
                        <div class="border-t border-slate-100 dark:border-slate-800 w-full"></div>
                        <div class="border-t border-slate-100 dark:border-slate-800 w-full"></div>
                        <div class="border-t border-slate-100 dark:border-slate-800 w-full"></div>
                        <div class="border-t border-slate-100 dark:border-slate-800 w-full"></div>
                    </div>

                    <!-- Line chart -->
                    <svg class="absolute inset-0 h-full w-full" preserveAspectRatio="none" viewBox="0 0 1000 300">
                        <defs>
                            <linearGradient id="chartGradient" x1="0" x2="0" y1="0" y2="1">
                                <stop offset="0%" stop-color="#1773cf" />
                                <stop offset="100%" stop-color="#1773cf" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                        <path d="M0 250 Q 100 220, 200 240 T 400 180 T 600 150 T 800 120 T 1000 80" fill="none"
                            stroke="#1773cf" stroke-linecap="round" stroke-width="4"></path>
                        <path d="M0 250 Q 100 220, 200 240 T 400 180 T 600 150 T 800 120 T 1000 80 L 1000 300 L 0 300 Z"
                            fill="url(#chartGradient)" opacity="0.1"></path>
                    </svg>

                    <!-- X-axis labels -->
                    <div
                        class="absolute bottom-[-24px] w-full flex justify-between px-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        <span>Jan</span>
                        <span>Feb</span>
                        <span>Mar</span>
                        <span>Apr</span>
                        <span>May</span>
                        <span>Jun</span>
                    </div>
                </div>
            </div>

            <!-- Asset Distribution -->
            <div
                class="bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6">Asset Distribution</h3>

                <div class="space-y-6">
                    <!-- Donut -->
                    <div class="flex items-center justify-center py-4">
                        <div class="relative size-32">
                            <svg class="size-full" viewBox="0 0 36 36">
                                <path class="text-slate-100 dark:text-slate-800"
                                    d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none" stroke="currentColor" stroke-dasharray="100, 100" stroke-width="3">
                                </path>
                                <path class="text-primary"
                                    d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none" stroke="currentColor" stroke-dasharray="65, 100" stroke-width="3"></path>
                                <path class="text-accent-gold"
                                    d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none" stroke="currentColor" stroke-dasharray="25, 100" stroke-dashoffset="-65"
                                    stroke-width="3"></path>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-2xl font-bold text-slate-900 dark:text-white">65%</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Invested</span>
                            </div>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="size-2 rounded-full bg-primary"></div>
                                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Fixed
                                    Deposits</span>
                            </div>
                            <span class="text-xs font-bold text-slate-900 dark:text-white">$18.5M</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="size-2 rounded-full bg-accent-gold"></div>
                                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Government
                                    Bonds</span>
                            </div>
                            <span class="text-xs font-bold text-slate-900 dark:text-white">$7.2M</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="size-2 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Liquid Cash</span>
                            </div>
                            <span class="text-xs font-bold text-slate-900 dark:text-white">$4.4M</span>
                        </div>
                    </div>

                    <button
                        class="w-full py-2.5 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        View Full Portfolio
                    </button>
                </div>
            </div>

        </div>

        <!-- ── Recent Transactions Table ───────────────────────────── -->
        <div
            class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">

            <div
                class="px-4 sm:px-6 py-5 flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Recent Transactions</h3>
                    <p class="text-sm text-slate-500">The most recent activity across the fund system.</p>
                </div>
                <button class="text-primary text-sm font-bold hover:underline whitespace-nowrap">
                    View All Transactions
                </button>
            </div>

            <!-- Horizontally scrollable on small screens -->
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[640px]">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                            <th class="px-4 sm:px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                Member</th>
                            <th class="px-4 sm:px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                Transaction ID</th>
                            <th class="px-4 sm:px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                Type</th>
                            <th class="px-4 sm:px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                Amount</th>
                            <th class="px-4 sm:px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                Date</th>
                            <th class="px-4 sm:px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                Status</th>
                            <th
                                class="px-4 sm:px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-right">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">

                        <!-- Row 1 -->
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs shrink-0">
                                        JD</div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white leading-none">Jane Doe
                                        </p>
                                        <p class="text-[10px] text-slate-500 mt-1">ID: PF-2938</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-xs font-mono text-slate-500">TXN-48291039</td>
                            <td class="px-4 sm:px-6 py-4">
                                <div
                                    class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                                    <span class="material-symbols-outlined text-primary text-sm">payments</span>
                                    Contribution
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-sm font-bold text-slate-900 dark:text-white">$1,200.00</td>
                            <td class="px-4 sm:px-6 py-4 text-xs text-slate-500">Oct 24, 2023</td>
                            <td class="px-4 sm:px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 text-[10px] font-bold uppercase">
                                    Completed
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-right">
                                <button class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </button>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-8 rounded-full bg-slate-200 dark:bg-slate-700 bg-cover bg-center shrink-0"
                                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuALEDa7sRgjbjJ8msAecvciiaMtk9xJoVVtch2wz26W5YM0k9uEOS18PcxEJwzvZo1pUSQiXQO1hXaGOnwXWDdmaGykLvjnYJSZlmLxVcbb_jfr-M84_DgNmyS77_g7WQZrFbRSZX2VANAdLekHO9dCEpq6X7GxUw0ZI-Yxof7NC_RF4WJa4zhgaZQkXdWWl5Xo8vTT4qSem1Hp-GpEI0nWvOs4VwYY1eYA3JF-ytFv45Fb1lcfIEDH5HpgxA4IcFCrjIbB-qa6_00')"
                                        aria-label="User avatar for Michael Smith"></div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white leading-none">Michael
                                            Smith</p>
                                        <p class="text-[10px] text-slate-500 mt-1">ID: PF-8472</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-xs font-mono text-slate-500">TXN-48291040</td>
                            <td class="px-4 sm:px-6 py-4">
                                <div
                                    class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                                    <span class="material-symbols-outlined text-accent-gold text-sm">receipt_long</span>
                                    Loan Disbursed
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-sm font-bold text-slate-900 dark:text-white">$15,000.00</td>
                            <td class="px-4 sm:px-6 py-4 text-xs text-slate-500">Oct 24, 2023</td>
                            <td class="px-4 sm:px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 text-[10px] font-bold uppercase">
                                    Completed
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-right">
                                <button class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </button>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs shrink-0">
                                        RS</div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white leading-none">Robert
                                            Shaw</p>
                                        <p class="text-[10px] text-slate-500 mt-1">ID: PF-5521</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-xs font-mono text-slate-500">TXN-48291041</td>
                            <td class="px-4 sm:px-6 py-4">
                                <div
                                    class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                                    <span class="material-symbols-outlined text-accent-red text-sm">wallet</span>
                                    Withdrawal
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-sm font-bold text-slate-900 dark:text-white">$3,500.00</td>
                            <td class="px-4 sm:px-6 py-4 text-xs text-slate-500">Oct 23, 2023</td>
                            <td class="px-4 sm:px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 text-[10px] font-bold uppercase">
                                    Pending
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-right">
                                <button class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </button>
                            </td>
                        </tr>

                        <!-- Row 4 -->
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-8 rounded-full bg-slate-200 dark:bg-slate-700 bg-cover bg-center shrink-0"
                                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBRqibhZLf2o7BvdF0aLDOKoqQqDleSF-EjWNUF6MDNhNEuE1cGu_Q60NTCowYVYixu0xVpnoj3lACCbr5JyCqr6PQsMGBul4uZpMuIcduANZEv4buXfoA_Va_PwMUKBjAbyWVYneYvs-hudTK12jZq9unJ-My5fz-Iecr0ycRxHy700X4I27hyU5Z6IcnqcyY2vq_esobWFXuZCYplTF0W_n9Gnn0RqdfLfymJKrT4XLirB7sVj3Xy7xtOue8TviJI0FiA_E3MCfk')"
                                        aria-label="User avatar for Sarah Wilson"></div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white leading-none">Sarah
                                            Wilson</p>
                                        <p class="text-[10px] text-slate-500 mt-1">ID: PF-1102</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-xs font-mono text-slate-500">TXN-48291042</td>
                            <td class="px-4 sm:px-6 py-4">
                                <div
                                    class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                                    <span class="material-symbols-outlined text-primary text-sm">history</span>
                                    Loan Repayment
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-sm font-bold text-slate-900 dark:text-white">$850.00</td>
                            <td class="px-4 sm:px-6 py-4 text-xs text-slate-500">Oct 23, 2023</td>
                            <td class="px-4 sm:px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 text-[10px] font-bold uppercase">
                                    Completed
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-right">
                                <button class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
