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
                        Active
                        <span class="material-symbols-outlined text-sm">people</span>
                    </span>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-slate-500 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2">Total Contributions</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">₵{{ number_format($stats['total_contributions'], 2) }}</h3>
                    <span class="text-emerald-500 text-xs font-bold flex items-center gap-0.5">
                        +{{ $stats['recent_contributions_count'] }}
                        <span class="material-symbols-outlined text-sm">trending_up</span>
                    </span>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-slate-500 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2">Loans Issued</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">₵{{ number_format($stats['loans_issued'], 2) }}</h3>
                    <span class="text-blue-500 text-xs font-bold flex items-center gap-0.5">
                        {{ $stats['active_loans'] }} active
                        <span class="material-symbols-outlined text-sm">account_balance</span>
                    </span>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-slate-500 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2">Total Repayments</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">₵{{ number_format($stats['total_repayments'], 2) }}</h3>
                    <span class="text-emerald-500 text-xs font-bold flex items-center gap-0.5">
                        +{{ $stats['recent_repayments_count'] }}
                        <span class="material-symbols-outlined text-sm">trending_up</span>
                    </span>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-slate-500 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2">Total Withdrawals</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">₵{{ number_format($stats['total_withdrawals'], 2) }}</h3>
                    <span class="text-amber-500 text-xs font-bold flex items-center gap-0.5">
                        {{ $stats['pending_withdrawals'] }} pending
                        <span class="material-symbols-outlined text-sm">schedule</span>
                    </span>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm ring-2 ring-primary ring-opacity-10">
                <p class="text-slate-500 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2">Fund Balance</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-xl sm:text-2xl font-bold text-primary">₵{{ number_format($stats['fund_balance'], 2) }}</h3>
                    <span class="text-emerald-500 text-xs font-bold flex items-center gap-0.5">
                        Available
                        <span class="material-symbols-outlined text-sm">account_balance_wallet</span>
                    </span>
                </div>
            </div>

        </div>

        <!-- ── Chart + Asset Distribution ─────────────────────────── -->
        {{-- <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 sm:gap-8">

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
                            <span class="text-xs font-bold text-slate-900 dark:text-white">₵{{ number_format($stats['fund_balance'] * 0.65, 0) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="size-2 rounded-full bg-accent-gold"></div>
                                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Government
                                    Bonds</span>
                            </div>
                            <span class="text-xs font-bold text-slate-900 dark:text-white">₵{{ number_format($stats['fund_balance'] * 0.25, 0) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="size-2 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Liquid Cash</span>
                            </div>
                            <span class="text-xs font-bold text-slate-900 dark:text-white">₵{{ number_format($stats['fund_balance'] * 0.10, 0) }}</span>
                        </div>
                    </div>

                    <button
                        class="w-full py-2.5 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        View Full Portfolio
                    </button>
                </div>
            </div>

        </div> --}}
        

        <!-- ── Statistics Summary ──────────────────────────────── -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="px-4 sm:px-6 py-5 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Fund Statistics Overview</h3>
                <p class="text-sm text-slate-500 mt-1">Complete summary of all provident fund statistics</p>
            </div>

            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Members Statistics -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Members</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Total Members</span>
                                <span class="font-bold text-slate-900 dark:text-white">{{ number_format($stats['members_count']) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contributions Statistics -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Contributions</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Total Amount</span>
                                <span class="font-bold text-slate-900 dark:text-white">₵{{ number_format($stats['total_contributions'], 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Recent (30 days)</span>
                                <span class="font-bold text-emerald-600">{{ $stats['recent_contributions_count'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Loans Statistics -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Loans</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Total Issued</span>
                                <span class="font-bold text-slate-900 dark:text-white">₵{{ number_format($stats['loans_issued'], 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Active Loans</span>
                                <span class="font-bold text-blue-600">{{ $stats['active_loans'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Pending Loans</span>
                                <span class="font-bold text-yellow-600">{{ $stats['pending_loans'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Repayments Statistics -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Repayments</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Total Amount</span>
                                <span class="font-bold text-slate-900 dark:text-white">₵{{ number_format($stats['total_repayments'], 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Recent (30 days)</span>
                                <span class="font-bold text-emerald-600">{{ $stats['recent_repayments_count'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Withdrawals Statistics -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Withdrawals</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Total Amount</span>
                                <span class="font-bold text-slate-900 dark:text-white">₵{{ number_format($stats['total_withdrawals'], 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Pending</span>
                                <span class="font-bold text-amber-600">{{ $stats['pending_withdrawals'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Fund Balance Statistics -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Fund Balance</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Current Balance</span>
                                <span class="font-bold text-primary">₵{{ number_format($stats['fund_balance'], 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Real-time Activities ──────────────────────────────── -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 sm:gap-8">

            <!-- Recent Activities Feed -->
            <div class="xl:col-span-1">
                <h2 class="text-slate-900 dark:text-slate-100 text-xl font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">schedule</span>
                    Recent Activities
                </h2>
                <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-4 space-y-4 max-h-96 overflow-y-auto">
                    @forelse($recentActivities as $activity)
                    <div class="flex items-start gap-3 p-3 rounded-lg bg-slate-50 dark:bg-slate-800/50">
                        <div class="size-8 rounded-lg bg-{{ $activity['color'] }}-100 dark:bg-{{ $activity['color'] }}-900/30 flex items-center justify-center text-{{ $activity['color'] }}-600 dark:text-{{ $activity['color'] }}-400 flex-shrink-0">
                            <span class="material-symbols-outlined text-sm">{{ $activity['icon'] }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $activity['title'] }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $activity['description'] }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $activity['date']->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-slate-500">
                        <span class="material-symbols-outlined text-3xl block mb-2 opacity-50">schedule</span>
                        <p class="text-sm">No recent activities</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6">Quick Stats</h3>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm text-yellow-600 dark:text-yellow-400">schedule</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Pending Loans</p>
                                <p class="text-xs text-slate-500">Awaiting approval</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ $stats['pending_loans'] }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm text-blue-600 dark:text-blue-400">account_balance</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Active Loans</p>
                                <p class="text-xs text-slate-500">Currently outstanding</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ $stats['active_loans'] }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm text-amber-600 dark:text-amber-400">wallet</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Pending Withdrawals</p>
                                <p class="text-xs text-slate-500">Under review</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ $stats['pending_withdrawals'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Contribution Trends Chart -->
            <div class="bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-8">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Contribution Trends</h3>
                        <p class="text-sm text-slate-500">Monthly contribution amounts over the last 6 months</p>
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

                    <!-- Dynamic Line chart -->
                    @php
                        $maxAmount = $contributionTrends->max('amount') ?: 1;
                        $chartHeight = 250;
                        $chartWidth = 1000;
                        $points = '';

                        foreach ($contributionTrends as $index => $trend) {
                            $x = ($index / (count($contributionTrends) - 1)) * $chartWidth;
                            $y = $chartHeight - (($trend['amount'] / $maxAmount) * ($chartHeight - 50));
                            $points .= ($index > 0 ? ' ' : '') . $x . ',' . $y;
                        }
                    @endphp

                    <svg class="absolute inset-0 h-full w-full" preserveAspectRatio="none" viewBox="0 0 {{ $chartWidth }} {{ $chartHeight }}">
                        <defs>
                            <linearGradient id="chartGradient" x1="0" x2="0" y1="0" y2="1">
                                <stop offset="0%" stop-color="#1773cf" />
                                <stop offset="100%" stop-color="#1773cf" stop-opacity="0" />
                            </linearGradient>
                        </defs>

                        @if($contributionTrends->count() > 1)
                            <!-- Area fill -->
                            <path d="M0 {{ $chartHeight }}
                                @foreach($contributionTrends as $index => $trend)
                                    @php
                                        $x = ($index / (count($contributionTrends) - 1)) * $chartWidth;
                                        $y = $chartHeight - (($trend['amount'] / $maxAmount) * ($chartHeight - 50));
                                    @endphp
                                    L{{ $x }} {{ $y }}
                                @endforeach
                                L{{ $chartWidth }} {{ $chartHeight }} Z"
                                fill="url(#chartGradient)" opacity="0.1"/>

                            <!-- Line -->
                            <polyline fill="none" stroke="#1773cf" stroke-width="3" stroke-linecap="round"
                                points="{{ $points }}"/>
                        @endif

                        <!-- Data points -->
                        @foreach($contributionTrends as $index => $trend)
                            @php
                                $x = ($index / (count($contributionTrends) - 1)) * $chartWidth;
                                $y = $chartHeight - (($trend['amount'] / $maxAmount) * ($chartHeight - 50));
                            @endphp
                            <circle cx="{{ $x }}" cy="{{ $y }}" r="4" fill="#1773cf" stroke="white" stroke-width="2"/>
                        @endforeach
                    </svg>

                    <!-- Y-axis labels (amounts) -->
                    <div class="absolute left-0 top-0 h-full flex flex-col justify-between text-[10px] font-bold text-slate-400 pr-2">
                        <span>₵{{ number_format($maxAmount, 0) }}</span>
                        <span>₵{{ number_format($maxAmount * 0.75, 0) }}</span>
                        <span>₵{{ number_format($maxAmount * 0.5, 0) }}</span>
                        <span>₵{{ number_format($maxAmount * 0.25, 0) }}</span>
                        <span>₵0</span>
                    </div>

                    <!-- X-axis labels (months) -->
                    <div class="absolute bottom-[-24px] w-full flex justify-between px-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        @foreach($contributionTrends as $trend)
                            <span>{{ $trend['month'] }}</span>
                        @endforeach
                    </div>

                    <!-- Tooltip on hover (simplified) -->
                    <div class="absolute top-4 right-4 bg-slate-900 text-white text-xs px-3 py-2 rounded-lg opacity-0 hover:opacity-100 transition-opacity">
                        Hover over points for details
                    </div>
                </div>

                <!-- Chart summary -->
                <div class="mt-4 grid grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-xs text-slate-500">Total This Period</p>
                        <p class="text-sm font-bold text-slate-900 dark:text-white">₵{{ number_format($contributionTrends->sum('amount'), 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Avg Monthly</p>
                        <p class="text-sm font-bold text-slate-900 dark:text-white">₵{{ number_format($contributionTrends->avg('amount'), 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Peak Month</p>
                        <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $contributionTrends->where('amount', $contributionTrends->max('amount'))->first()['month'] ?? 'N/A' }}</p>
                    </div>
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
                        @forelse($recentTransactions as $transaction)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ substr($transaction['member_name'], 0, 1) }}{{ substr(explode(' ', $transaction['member_name'])[1] ?? '', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white leading-none">{{ $transaction['member_name'] }}</p>
                                        <p class="text-[10px] text-slate-500 mt-1">ID: {{ $transaction['member_id'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-xs font-mono text-slate-500">{{ $transaction['transaction_id'] }}</td>
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                                    <span class="material-symbols-outlined text-{{ $transaction['type_color'] }} text-sm">{{ $transaction['type_icon'] }}</span>
                                    {{ $transaction['type'] }}
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-sm font-bold text-slate-900 dark:text-white">₵{{ number_format($transaction['amount'] / 100, 2) }}</td>
                            <td class="px-4 sm:px-6 py-4 text-xs text-slate-500">{{ $transaction['date']->format('M d, Y') }}</td>
                            <td class="px-4 sm:px-6 py-4">
                                <span class="px-2 py-1 rounded-full bg-{{ $transaction['status_color'] }}-100 text-{{ $transaction['status_color'] }}-700 dark:bg-{{ $transaction['status_color'] }}-900/30 dark:text-{{ $transaction['status_color'] }}-400 text-[10px] font-bold uppercase">
                                    {{ $transaction['status'] }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-right">
                                <button class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 sm:px-6 py-8 text-center text-slate-500">
                                <span class="material-symbols-outlined text-3xl block mb-2 opacity-50">receipt_long</span>
                                <p class="text-sm">No recent transactions</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
