@extends('layouts.app')

@section('title', 'Staff Statements')

@section('content')
    <div class="max-w-6xl mx-auto">

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
            <!-- Left: Report Generator Panel -->
            <section class="xl:col-span-8 space-y-8">
                <div
                    class="bg-surface-container-lowest p-8 rounded-lg shadow-sm border-l-4 border-primary">
                    <h2 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-8">
                        Staff Statements</h2>
                    <form class="space-y-8">
                        <!-- Report Type Selection -->
                        <div>
                            <label
                                class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-4">Select
                                Report Type</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <label
                                    class="relative flex flex-col p-4 cursor-pointer rounded-lg border border-outline-variant hover:bg-surface-variant transition-colors has-[:checked]:bg-primary/5 has-[:checked]:border-primary">
                                    <input checked="" class="sr-only" name="report_type"
                                        type="radio" />
                                    <span
                                        class="material-symbols-outlined text-primary mb-2">list_alt</span>
                                    <span class="font-bold text-sm block">Detailed History</span>
                                    <span class="text-[10px] text-slate-500 mt-1">Full transaction
                                        log</span>
                                </label>
                                <label
                                    class="relative flex flex-col p-4 cursor-pointer rounded-lg border border-outline-variant hover:bg-surface-variant transition-colors has-[:checked]:bg-primary/5 has-[:checked]:border-primary">
                                    <input class="sr-only" name="report_type" type="radio" />
                                    <span
                                        class="material-symbols-outlined text-secondary mb-2">calendar_month</span>
                                    <span class="font-bold text-sm block">Annual Summary</span>
                                    <span class="text-[10px] text-slate-500 mt-1">Yearly
                                        performance</span>
                                </label>
                                <label
                                    class="relative flex flex-col p-4 cursor-pointer rounded-lg border border-outline-variant hover:bg-surface-variant transition-colors has-[:checked]:bg-primary/5 has-[:checked]:border-primary">
                                    <input class="sr-only" name="report_type" type="radio" />
                                    <span
                                        class="material-symbols-outlined text-tertiary mb-2">verified_user</span>
                                    <span class="font-bold text-sm block">Tax Certificate</span>
                                    <span class="text-[10px] text-slate-500 mt-1">Official
                                        declaration</span>
                                </label>
                            </div>
                        </div>
                        <!-- Date Range and Format -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <label
                                    class="block text-[10px] font-black uppercase tracking-widest text-slate-500">Date
                                    Range</label>
                                <div class="flex items-center gap-3">
                                    <div class="flex-1">
                                        <input
                                            class="w-full bg-slate-50 border-none rounded-lg text-sm font-bold text-on-surface-variant p-3 focus:ring-2 focus:ring-primary"
                                            type="date" />
                                    </div>
                                    <span class="text-slate-400 font-black">TO</span>
                                    <div class="flex-1">
                                        <input
                                            class="w-full bg-slate-50 border-none rounded-lg text-sm font-bold text-on-surface-variant p-3 focus:ring-2 focus:ring-primary"
                                            type="date" />
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <label
                                    class="block text-[10px] font-black uppercase tracking-widest text-slate-500">Output
                                    Format</label>
                                <div class="flex gap-4">
                                    <label
                                        class="flex-1 flex items-center justify-center gap-2 p-3 rounded-lg border border-outline-variant cursor-pointer hover:bg-slate-50 has-[:checked]:bg-slate-900 has-[:checked]:text-white transition-all">
                                        <input checked="" class="sr-only" name="format"
                                            type="radio" value="pdf" />
                                        <span
                                            class="material-symbols-outlined text-sm">picture_as_pdf</span>
                                        <span class="font-bold text-xs uppercase">PDF</span>
                                    </label>
                                    <label
                                        class="flex-1 flex items-center justify-center gap-2 p-3 rounded-lg border border-outline-variant cursor-pointer hover:bg-slate-50 has-[:checked]:bg-slate-900 has-[:checked]:text-white transition-all">
                                        <input class="sr-only" name="format" type="radio"
                                            value="excel" />
                                        <span
                                            class="material-symbols-outlined text-sm">table_view</span>
                                        <span class="font-bold text-xs uppercase">Excel</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                            <p
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest max-w-[200px]">
                                Reports may take up to 30 seconds to generate</p>
                            <button
                                class="bg-primary text-white px-10 py-4 font-black uppercase tracking-widest text-xs rounded shadow-xl shadow-primary/30 hover:shadow-primary/40 active:scale-95 transition-all"
                                type="submit">
                                Generate Report
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Data Density Showcase (Asymmetric Layout) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-secondary/10 p-6 rounded-lg border-l-4 border-secondary">
                        <span class="material-symbols-outlined text-secondary text-3xl mb-4"
                            data-weight="fill" style="font-variation-settings: 'FILL' 1;">stars</span>
                        <h3 class="text-sm font-black uppercase tracking-widest mb-1">Total Accumulated
                            Value</h3>
                        <p class="text-3xl font-black text-on-surface">$284,930.42</p>
                        <p class="text-[10px] font-bold text-slate-500 mt-2 uppercase">Verified As Of
                            October 2023</p>
                    </div>
                    <div class="bg-primary/10 p-6 rounded-lg border-l-4 border-primary">
                        <span class="material-symbols-outlined text-primary text-3xl mb-4"
                            data-weight="fill"
                            style="font-variation-settings: 'FILL' 1;">trending_up</span>
                        <h3 class="text-sm font-black uppercase tracking-widest mb-1">Fiscal Year
                            Contribution</h3>
                        <p class="text-3xl font-black text-on-surface">$12,400.00</p>
                        <p class="text-[10px] font-bold text-slate-500 mt-2 uppercase">8% Increase from
                            Last Year</p>
                    </div>
                </div>
            </section>
            <!-- Right: Recently Generated Statements -->
            <aside class="xl:col-span-4">
                <div class="bg-surface-container-lowest rounded-lg shadow-sm">
                    <div class="p-6 border-b border-slate-50">
                        <h2 class="text-xs font-black uppercase tracking-[0.2em] text-on-surface">
                            Recent Downloads</h2>
                    </div>
                    <div class="divide-y divide-slate-50">
                        <!-- Statement Item -->
                        <div class="p-5 hover:bg-blue-50/50 transition-colors group">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="bg-red-50 text-tertiary p-2 rounded">
                                        <span class="material-symbols-outlined">picture_as_pdf</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-on-surface leading-tight">FY
                                            2022-23 Annual Summary</p>
                                        <p
                                            class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">
                                            Generated Oct 12, 2023</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <span
                                    class="text-[10px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-black uppercase">Ready</span>
                                <a class="flex items-center gap-1 text-[10px] font-black uppercase text-primary tracking-widest group-hover:underline"
                                    href="#">
                                    Download <span
                                        class="material-symbols-outlined text-xs">download</span>
                                </a>
                            </div>
                        </div>
                        <!-- Statement Item -->
                        <div class="p-5 hover:bg-blue-50/50 transition-colors group">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="bg-emerald-50 text-emerald-700 p-2 rounded">
                                        <span class="material-symbols-outlined">table_view</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-on-surface leading-tight">Q3
                                            Detailed Transaction Log</p>
                                        <p
                                            class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">
                                            Generated Sep 28, 2023</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <span
                                    class="text-[10px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-black uppercase">Ready</span>
                                <a class="flex items-center gap-1 text-[10px] font-black uppercase text-primary tracking-widest group-hover:underline"
                                    href="#">
                                    Download <span
                                        class="material-symbols-outlined text-xs">download</span>
                                </a>
                            </div>
                        </div>
                        <!-- Statement Item -->
                        <div class="p-5 hover:bg-blue-50/50 transition-colors group">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="bg-red-50 text-tertiary p-2 rounded">
                                        <span class="material-symbols-outlined">picture_as_pdf</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-on-surface leading-tight">Tax
                                            Certificate 2022</p>
                                        <p
                                            class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">
                                            Generated Feb 15, 2023</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <span
                                    class="text-[10px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-black uppercase">Ready</span>
                                <a class="flex items-center gap-1 text-[10px] font-black uppercase text-primary tracking-widest group-hover:underline"
                                    href="#">
                                    Download <span
                                        class="material-symbols-outlined text-xs">download</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-slate-50/50 rounded-b-lg text-center">
                        <a class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-primary transition-colors"
                            href="#">View Archived History</a>
                    </div>
                </div>
                <!-- Info Card -->
                <div
                    class="mt-8 bg-inverse-surface text-inverse-on-surface p-6 rounded-lg relative overflow-hidden">
                    <div class="relative z-10">
                        <h4 class="text-sm font-black uppercase tracking-widest mb-2">Need a Physical
                            Copy?</h4>
                        <p class="text-xs text-slate-300 mb-6 leading-relaxed">Official stamped and
                            signed physical copies can be requested through the institutional mailing
                            service. Fees may apply.</p>
                        <button
                            class="text-[10px] font-black uppercase tracking-widest border border-slate-500 px-4 py-2 hover:bg-white hover:text-slate-900 transition-all">Request
                            Courier</button>
                    </div>
                    <div class="absolute -right-4 -bottom-4 opacity-10">
                        <span class="material-symbols-outlined text-[100px]"
                            style="font-variation-settings: 'FILL' 1;">account_balance</span>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
