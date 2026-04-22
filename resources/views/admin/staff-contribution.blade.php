@extends('layouts.app')

@section('title', 'Contributions')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-4xl lg:text-5xl font-black text-on-surface tracking-tighter">
                Contributions</h1>
            <p class="text-on-surface-variant font-medium mt-2">Historical ledger of all member and
                employer capital injections.</p>
        </div>
        <button
            class="flex items-center gap-2 px-6 py-2.5 bg-surface-container-lowest border border-outline text-primary font-bold text-sm hover:bg-surface-variant transition-colors shadow-sm">
            <span class="material-symbols-outlined text-lg">download</span>
            Export History
        </button>
    </div>
    <!-- Top Summary Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Personal Contributions -->
        <div
            class="bg-surface-container-lowest p-6 shadow-sm border-l-4 border-primary flex flex-col justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total
                    Personal Contributions</span>
                <div class="text-3xl font-black text-primary mt-1">$42,500.00</div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs text-emerald-600 font-bold">
                <span class="material-symbols-outlined text-sm">trending_up</span>
                +12% from last year
            </div>
        </div>
        <!-- Employer Match -->
        <div
            class="bg-surface-container-lowest p-6 shadow-sm border-l-4 border-secondary flex flex-col justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total
                    Employer Match</span>
                <div class="text-3xl font-black text-secondary mt-1">$21,250.00</div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs text-slate-500 font-bold">
                <span class="material-symbols-outlined text-sm">lock</span>
                50% Match Active
            </div>
        </div>
        <!-- Cumulative Growth -->
        <div
            class="bg-surface-container-lowest p-6 shadow-sm border-l-4 border-primary flex flex-col justify-between">
            <div>
                <span
                    class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Cumulative
                    Growth</span>
                <div class="text-3xl font-black text-on-surface mt-1">$6,842.12</div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs text-emerald-600 font-bold">
                <span class="material-symbols-outlined text-sm">insights</span>
                8.4% Annualized Return
            </div>
        </div>
        <!-- Next Scheduled -->
        <div
            class="bg-primary/5 p-6 shadow-sm border-l-4 border-primary flex flex-col justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-primary/60">Next
                    Scheduled</span>
                <div class="text-xl font-bold text-primary mt-1">OCT 15, 2023</div>
            </div>
            <div class="mt-4 text-xs font-bold text-primary">
                Auto-debit from Ledger • $450.00
            </div>
        </div>
    </div>
    <!-- Visualization & Secondary Metrics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-surface-container-lowest p-8 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl font-black tracking-tight">12-Month Performance</h2>
                <div class="flex gap-4">
                    <div
                        class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest">
                        <span class="w-3 h-3 bg-primary"></span> Personal
                    </div>
                    <div
                        class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest">
                        <span class="w-3 h-3 bg-secondary"></span> Match
                    </div>
                </div>
            </div>
            <!-- Simplified Bar Chart Representation -->
            <div class="h-64 flex items-end justify-between gap-3 px-2">
                <!-- Bars -->
                <div class="flex-1 flex flex-col justify-end gap-1 group">
                    <div class="w-full bg-secondary h-12 transition-all group-hover:opacity-80">
                    </div>
                    <div class="w-full bg-primary h-24 transition-all group-hover:opacity-80">
                    </div>
                    <span
                        class="text-[9px] font-bold text-slate-400 mt-2 text-center uppercase tracking-tighter">Nov</span>
                </div>
                <div class="flex-1 flex flex-col justify-end gap-1 group">
                    <div class="w-full bg-secondary h-10 transition-all group-hover:opacity-80">
                    </div>
                    <div class="w-full bg-primary h-20 transition-all group-hover:opacity-80">
                    </div>
                    <span
                        class="text-[9px] font-bold text-slate-400 mt-2 text-center uppercase tracking-tighter">Dec</span>
                </div>
                <div class="flex-1 flex flex-col justify-end gap-1 group">
                    <div class="w-full bg-secondary h-14 transition-all group-hover:opacity-80">
                    </div>
                    <div class="w-full bg-primary h-28 transition-all group-hover:opacity-80">
                    </div>
                    <span
                        class="text-[9px] font-bold text-slate-400 mt-2 text-center uppercase tracking-tighter">Jan</span>
                </div>
                <div class="flex-1 flex flex-col justify-end gap-1 group">
                    <div class="w-full bg-secondary h-12 transition-all group-hover:opacity-80">
                    </div>
                    <div class="w-full bg-primary h-24 transition-all group-hover:opacity-80">
                    </div>
                    <span
                        class="text-[9px] font-bold text-slate-400 mt-2 text-center uppercase tracking-tighter">Feb</span>
                </div>
                <div class="flex-1 flex flex-col justify-end gap-1 group">
                    <div class="w-full bg-secondary h-16 transition-all group-hover:opacity-80">
                    </div>
                    <div class="w-full bg-primary h-32 transition-all group-hover:opacity-80">
                    </div>
                    <span
                        class="text-[9px] font-bold text-slate-400 mt-2 text-center uppercase tracking-tighter">Mar</span>
                </div>
                <div class="flex-1 flex flex-col justify-end gap-1 group">
                    <div class="w-full bg-secondary h-14 transition-all group-hover:opacity-80">
                    </div>
                    <div class="w-full bg-primary h-28 transition-all group-hover:opacity-80">
                    </div>
                    <span
                        class="text-[9px] font-bold text-slate-400 mt-2 text-center uppercase tracking-tighter">Apr</span>
                </div>
                <div class="flex-1 flex flex-col justify-end gap-1 group">
                    <div class="w-full bg-secondary h-15 transition-all group-hover:opacity-80">
                    </div>
                    <div class="w-full bg-primary h-30 transition-all group-hover:opacity-80">
                    </div>
                    <span
                        class="text-[9px] font-bold text-slate-400 mt-2 text-center uppercase tracking-tighter">May</span>
                </div>
                <div class="flex-1 flex flex-col justify-end gap-1 group">
                    <div class="w-full bg-secondary h-18 transition-all group-hover:opacity-80">
                    </div>
                    <div class="w-full bg-primary h-36 transition-all group-hover:opacity-80">
                    </div>
                    <span
                        class="text-[9px] font-bold text-slate-400 mt-2 text-center uppercase tracking-tighter">Jun</span>
                </div>
                <div class="flex-1 flex flex-col justify-end gap-1 group">
                    <div class="w-full bg-secondary h-16 transition-all group-hover:opacity-80">
                    </div>
                    <div class="w-full bg-primary h-32 transition-all group-hover:opacity-80">
                    </div>
                    <span
                        class="text-[9px] font-bold text-slate-400 mt-2 text-center uppercase tracking-tighter">Jul</span>
                </div>
                <div class="flex-1 flex flex-col justify-end gap-1 group">
                    <div class="w-full bg-secondary h-17 transition-all group-hover:opacity-80">
                    </div>
                    <div class="w-full bg-primary h-34 transition-all group-hover:opacity-80">
                    </div>
                    <span
                        class="text-[9px] font-bold text-slate-400 mt-2 text-center uppercase tracking-tighter">Aug</span>
                </div>
                <div class="flex-1 flex flex-col justify-end gap-1 group">
                    <div class="w-full bg-secondary h-19 transition-all group-hover:opacity-80">
                    </div>
                    <div class="w-full bg-primary h-38 transition-all group-hover:opacity-80">
                    </div>
                    <span
                        class="text-[9px] font-bold text-slate-400 mt-2 text-center uppercase tracking-tighter">Sep</span>
                </div>
                <div class="flex-1 flex flex-col justify-end gap-1 group">
                    <div class="w-full bg-secondary h-20 transition-all group-hover:opacity-80">
                    </div>
                    <div class="w-full bg-primary h-40 transition-all group-hover:opacity-80">
                    </div>
                    <span
                        class="text-[9px] font-bold text-slate-400 mt-2 text-center uppercase tracking-tighter font-black text-primary">Oct</span>
                </div>
            </div>
        </div>
        <div class="space-y-6">
            <div
                class="bg-slate-900 text-white p-8 shadow-sm h-full flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-black text-secondary uppercase tracking-widest italic">
                        Institutional Grade</h3>
                    <p class="text-slate-400 text-sm mt-4 leading-relaxed">Your account is
                        currently outperforming the market baseline by 3.2%. Maintain current
                        contribution levels to reach your goal 14 months earlier.</p>
                </div>
                <div class="mt-8 border-t border-slate-800 pt-6">
                    <div class="flex justify-between items-end mb-2">
                        <span
                            class="text-xs font-bold uppercase tracking-widest text-slate-500">Milestone
                            Progress</span>
                        <span class="text-lg font-black">74%</span>
                    </div>
                    <div class="w-full bg-slate-800 h-2">
                        <div class="bg-secondary h-full w-[74%]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Transaction Table Section -->
    <div class="bg-surface-container-lowest shadow-sm">
        <div
            class="p-6 border-b border-outline-variant flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-lg font-black uppercase tracking-widest">Transaction Ledger</h3>
            <div class="flex flex-wrap items-center gap-3">
                <select
                    class="text-xs font-bold uppercase tracking-widest border-outline-variant focus:ring-primary rounded-lg">
                    <option>All Types</option>
                    <option>Personal</option>
                    <option>Employer Match</option>
                    <option>Dividend</option>
                </select>
                <select
                    class="text-xs font-bold uppercase tracking-widest border-outline-variant focus:ring-primary rounded-lg">
                    <option>Last 30 Days</option>
                    <option>Last 90 Days</option>
                    <option>Year to Date</option>
                </select>
                <button
                    class="flex items-center gap-2 p-2 hover:bg-surface-variant transition-colors border border-outline-variant rounded-lg">
                    <span class="material-symbols-outlined text-lg">filter_list</span>
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50">
                        <th
                            class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">
                            Date</th>
                        <th
                            class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">
                            Type</th>
                        <th
                            class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">
                            Description</th>
                        <th
                            class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500 text-right">
                            Amount</th>
                        <th
                            class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">
                            Status</th>
                        <th
                            class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-sm">OCT 01, 2023</td>
                        <td class="px-6 py-5">
                            <span
                                class="text-[10px] font-bold uppercase px-2 py-1 bg-primary/10 text-primary">Personal</span>
                        </td>
                        <td class="px-6 py-5 text-sm text-on-surface-variant">Monthly Recurring
                            Contribution</td>
                        <td class="px-6 py-5 text-sm font-black text-right">$450.00</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span
                                    class="text-[10px] font-bold uppercase text-emerald-600">Settled</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <button
                                class="material-symbols-outlined text-slate-400 hover:text-primary transition-colors text-lg">more_horiz</button>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-sm">SEP 28, 2023</td>
                        <td class="px-6 py-5">
                            <span
                                class="text-[10px] font-bold uppercase px-2 py-1 bg-secondary/10 text-secondary">Match</span>
                        </td>
                        <td class="px-6 py-5 text-sm text-on-surface-variant">Employer Matching
                            Tier 1</td>
                        <td class="px-6 py-5 text-sm font-black text-right">$225.00</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span
                                    class="text-[10px] font-bold uppercase text-emerald-600">Settled</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <button
                                class="material-symbols-outlined text-slate-400 hover:text-primary transition-colors text-lg">more_horiz</button>
                        </td>
                    </tr>
                    <!-- Row 3 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-sm">SEP 15, 2023</td>
                        <td class="px-6 py-5">
                            <span
                                class="text-[10px] font-bold uppercase px-2 py-1 bg-primary/10 text-primary">Personal</span>
                        </td>
                        <td class="px-6 py-5 text-sm text-on-surface-variant">Ad-hoc One-time
                            Injection</td>
                        <td class="px-6 py-5 text-sm font-black text-right">$1,200.00</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span
                                    class="text-[10px] font-bold uppercase text-emerald-600">Settled</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <button
                                class="material-symbols-outlined text-slate-400 hover:text-primary transition-colors text-lg">more_horiz</button>
                        </td>
                    </tr>
                    <!-- Row 4 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-sm">SEP 01, 2023</td>
                        <td class="px-6 py-5">
                            <span
                                class="text-[10px] font-bold uppercase px-2 py-1 bg-primary/10 text-primary">Personal</span>
                        </td>
                        <td class="px-6 py-5 text-sm text-on-surface-variant">Monthly Recurring
                            Contribution</td>
                        <td class="px-6 py-5 text-sm font-black text-right">$450.00</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span
                                    class="text-[10px] font-bold uppercase text-emerald-600">Settled</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <button
                                class="material-symbols-outlined text-slate-400 hover:text-primary transition-colors text-lg">more_horiz</button>
                        </td>
                    </tr>
                    <!-- Row 5 -->
                    <tr class="hover:bg-slate-50 transition-colors opacity-60">
                        <td class="px-6 py-5 font-bold text-sm">AUG 30, 2023</td>
                        <td class="px-6 py-5">
                            <span
                                class="text-[10px] font-bold uppercase px-2 py-1 bg-slate-100 text-slate-500">Adjustment</span>
                        </td>
                        <td class="px-6 py-5 text-sm text-on-surface-variant">Fee Reversal
                            Adjustment</td>
                        <td class="px-6 py-5 text-sm font-black text-right text-emerald-600">
                            +$12.50</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                <span
                                    class="text-[10px] font-bold uppercase text-slate-500">Archived</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <button
                                class="material-symbols-outlined text-slate-400 hover:text-primary transition-colors text-lg">more_horiz</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-outline-variant flex items-center justify-between">
            <span class="text-xs font-bold text-slate-400">Showing 1-10 of 48 transactions</span>
            <div class="flex gap-2">
                <button
                    class="px-4 py-2 text-xs font-black uppercase tracking-widest border border-outline hover:bg-surface-variant disabled:opacity-30"
                    disabled="">Prev</button>
                <button
                    class="px-4 py-2 text-xs font-black uppercase tracking-widest border border-outline hover:bg-surface-variant">Next</button>
            </div>
        </div>
    </div>
    <!-- Contextual Help / Action -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-surface-container-low p-6 flex items-start gap-4">
            <div
                class="w-10 h-10 flex-shrink-0 bg-primary/10 flex items-center justify-center rounded-lg text-primary">
                <span class="material-symbols-outlined">trending_up</span>
            </div>
            <div>
                <h4 class="font-bold text-sm">Increase Contributions</h4>
                <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">Boost your monthly
                    savings to maximize employer matching benefits.</p>
                <a class="inline-block mt-3 text-[10px] font-black uppercase tracking-widest text-primary border-b border-primary/20 hover:border-primary"
                    href="#">Update Plan</a>
            </div>
        </div>
        <div class="bg-surface-container-low p-6 flex items-start gap-4">
            <div
                class="w-10 h-10 flex-shrink-0 bg-secondary/10 flex items-center justify-center rounded-lg text-secondary">
                <span class="material-symbols-outlined">receipt_long</span>
            </div>
            <div>
                <h4 class="font-bold text-sm">Annual Summary</h4>
                <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">Download your
                    certified annual contribution statement for tax purposes.</p>
                <a class="inline-block mt-3 text-[10px] font-black uppercase tracking-widest text-primary border-b border-primary/20 hover:border-primary"
                    href="#">Download PDF</a>
            </div>
        </div>
        <div class="bg-surface-container-low p-6 flex items-start gap-4">
            <div
                class="w-10 h-10 flex-shrink-0 bg-error/10 flex items-center justify-center rounded-lg text-error">
                <span class="material-symbols-outlined">shield</span>
            </div>
            <div>
                <h4 class="font-bold text-sm">Protection &amp; Security</h4>
                <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">Learn how Azure
                    Ledger protects your institutional capital assets.</p>
                <a class="inline-block mt-3 text-[10px] font-black uppercase tracking-widest text-primary border-b border-primary/20 hover:border-primary"
                    href="#">Security Protocol</a>
            </div>
        </div>
    </div>
    
@endsection