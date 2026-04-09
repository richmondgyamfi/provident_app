@extends('layouts.app')

@section('title', 'Payroll & Contribution Upload')

@section('content')
    <div class="p-4 sm:p-8 space-y-6 sm:space-y-8">
        <!-- Page Title Section -->
        <div class="flex flex-wrap justify-between items-end gap-3 px-4">
            <div class="flex min-w-72 flex-col gap-2">
                <h1 class="text-slate-900 dark:text-slate-100 text-4xl font-black leading-tight tracking-tight">
                    Payroll &amp; Contribution Upload</h1>
                <p class="text-slate-500 dark:text-slate-400 text-base font-normal leading-normal">Manage and
                    reconcile member contributions through manual entry or bulk file uploads.</p>
            </div>
            <div class="flex gap-3">
                <button
                    class="flex items-center justify-center rounded-lg h-10 px-4 bg-accent-gold text-white text-sm font-bold tracking-tight hover:bg-accent-gold/90 transition-all shadow-sm">
                    <span class="material-symbols-outlined mr-2 text-[20px]">add</span>
                    New Contribution
                </button>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="px-4">
            <div class="flex border-b border-slate-200 dark:border-slate-800 gap-8">
                <a id="tab-manual"
                    class="tab-link flex items-center justify-center border-b-2 border-primary text-primary pb-3 pt-4 cursor-pointer transition-colors"
                    onclick="switchTab('manual')">
                    <span class="material-symbols-outlined mr-2 text-[18px]">edit_note</span>
                    <p class="text-sm font-bold leading-normal">Manual Entry</p>
                </a>
                <a id="tab-bulk"
                    class="tab-link flex items-center justify-center border-b-2 border-transparent text-slate-500 dark:text-slate-400 pb-3 pt-4 hover:text-primary transition-colors cursor-pointer"
                    onclick="switchTab('bulk')">
                    <span class="material-symbols-outlined mr-2 text-[18px]">cloud_upload</span>
                    <p class="text-sm font-bold leading-normal">Bulk Upload</p>
                </a>
            </div>
        </div>

        <!-- ===================== MANUAL ENTRY TAB ===================== -->
        <div id="panel-manual" class="tab-panel px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-7">

                <!-- Left: Form -->
                <div class="lg:col-span-2 flex flex-col gap-6">

                    @if (session('success'))
                        <div class="bg-green-100 text-green-800 p-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 text-red-800 p-4 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-800 p-4 rounded">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Member Lookup -->
                    <form method="POST"
                        action="{{ isset($contribution) ? route('contributions.update', $contribution) : route('contributions.store') }}">
                        @csrf


                        <!-- Contribution Details Form -->

                        @if (isset($contribution))
                            @method('PUT')
                            <input type="hidden" name="member_id" value="{{ $contribution->member_id }}">
                            <input type="hidden" name="staff_no" value="{{ $contribution->staff_no }}">
                        @else
                            <div
                                class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                                <h3 class="text-slate-900 dark:text-slate-100 text-lg font-bold mb-5">Member Lookup</h3>
                                <div class="flex gap-3">
                                    <div class="relative flex-1">
                                        <span
                                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
                                        <input list="members" name="member_id" id="member-search" autocomplete="off"
                                            class="w-full pl-10 pr-4 h-11 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition"
                                            placeholder="Search by name or ID..." required />
                                        <datalist id="members">
                                            {{-- @if (isset($contribution) && $contribution->member)
                                            <option value="{{ $contribution->member_id }}">
                                                {{ $contribution->member->name ?? 'Unknown' }}
                                                ({{ $contribution->staff_no }})
                                            </option>
                                        @endif --}}
                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}">{{ $member->name }}
                                                    ({{ $member->staff_no }})
                                                </option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <button type="button" onclick="location.reload()"
                                        class="h-11 px-5 rounded-lg bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-all">
                                        Refresh
                                    </button>
                                </div>
                                @error('member_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                        <div
                            class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                            <h3 class="text-slate-900 dark:text-slate-100 text-lg font-bold mb-5">
                                {{ isset($contribution) ? 'Edit Contribution' : 'New Contribution' }}
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                                <!-- Period -->
                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Contribution
                                        Period</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="text-xs text-slate-400">Year</label>
                                            <input type="number" name="payroll_year" min="2000" max="2100"
                                                value="{{ isset($contribution) ? $contribution->payroll_year : old('payroll_year', date('Y')) }}"
                                                class="w-full h-11 px-4 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition"
                                                required />
                                        </div>
                                        <div>
                                            <label class="text-xs text-slate-400">Month</label>
                                            <select name="payroll_month"
                                                class="w-full h-11 px-4 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition"
                                                required>
                                                @for ($m = 1; $m <= 12; $m++)
                                                    <option value="{{ $m }}"
                                                        {{ (isset($contribution) ? $contribution->payroll_month : old('payroll_month')) == $m ? 'selected' : '' }}>
                                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contribution Type -->
                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Contribution
                                        Type</label>
                                    <select name="contribution_type"
                                        class="h-11 px-4 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition appearance-none"
                                        required>
                                        <option value="">Select type...</option>
                                        <option value="Mandatory"
                                            {{ (isset($contribution) ? $contribution->contribution_type : old('contribution_type')) == 'Mandatory' ? 'selected' : '' }}>
                                            Mandatory</option>
                                        <option value="Voluntary"
                                            {{ (isset($contribution) ? $contribution->contribution_type : old('contribution_type')) == 'Voluntary' ? 'selected' : '' }}>
                                            Voluntary</option>
                                        <option value="Arrears"
                                            {{ (isset($contribution) ? $contribution->contribution_type : old('contribution_type')) == 'Arrears' ? 'selected' : '' }}>
                                            Arrears</option>
                                        <option value="Adjustment"
                                            {{ (isset($contribution) ? $contribution->contribution_type : old('contribution_type')) == 'Adjustment' ? 'selected' : '' }}>
                                            Adjustment</option>
                                    </select>
                                </div>

                                <!-- Employee Share -->
                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Employee
                                        Month
                                        Contribution (GHS)</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">₵</span>
                                        <input type="number" step="0.01" name="employee_amount"
                                            value="{{ isset($contribution) ? $contribution->employee_amount : old('employee_amount', 0) }}"
                                            placeholder="0.00"
                                            class="w-full pl-8 pr-4 h-11 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition"
                                            required />
                                    </div>
                                </div>

                                <!-- Employer Share -->
                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Employer
                                        Yearly
                                        Contribution (GHS)</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">₵</span>
                                        <input type="number" step="0.01" name="employer_amount"
                                            value="{{ isset($contribution) ? $contribution->employer_amount : old('employer_amount', 0) }}"
                                            placeholder="0.00"
                                            class="w-full pl-8 pr-4 h-11 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition"
                                            required />
                                    </div>
                                </div>

                                <!-- Basic Salary -->
                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Basic
                                        Salary (GHS)</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">₵</span>
                                        <input type="number" step="0.01" name="basic_salary"
                                            value="{{ isset($contribution) ? $contribution->basic_salary : old('basic_salary') }}"
                                            placeholder="0.00"
                                            class="w-full pl-8 pr-4 h-11 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition" />
                                    </div>
                                </div>

                                <!-- Payment Reference -->
                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Payment
                                        Reference</label>
                                    <input type="text" name="payment_reference"
                                        value="{{ isset($contribution) ? $contribution->payment_reference : old('payment_reference') }}"
                                        placeholder="e.g. TXN-20231024-001"
                                        class="h-11 px-4 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition" />
                                </div>

                                <!-- Notes (full width) -->
                                <div class="flex flex-col gap-1.5 sm:col-span-2">
                                    <label
                                        class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Notes
                                        / Remarks <span class="normal-case font-normal">(optional)</span></label>
                                    <textarea rows="3" name="notes" placeholder="Any additional context for this contribution..."
                                        class="px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition resize-none">{{ isset($contribution) ? $contribution->notes : old('notes') }}</textarea>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex justify-end gap-3 mt-6 pt-5 border-t border-slate-100 dark:border-slate-800">
                                <input type="hidden" name="source" value="manual">
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6 pt-5 border-t border-slate-100 dark:border-slate-800">
                            <button type="button"
                                onclick="window.location.href='{{ route('payroll-contribution.create') }}'"
                                class="h-11 px-6 rounded-lg border border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                                Clear Form
                            </button>
                            <button type="submit"
                                class="h-11 px-6 rounded-lg bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-all shadow-sm flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">save</span>
                                {{ isset($contribution) ? 'Update Contribution' : 'Save Contribution' }}
                            </button>
                        </div>
                </div>
                </form>

                <!-- Recent Manual Entries Table for the year -->
                <div
                    class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                    <div
                        class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                        <h3 class="text-slate-900 dark:text-slate-100 text-lg font-bold mb-4">Entry Summary {{ date('Y') }}</h3>
                        <div class="flex flex-col gap-4">
                            <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg flex flex-col gap-1">
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium uppercase tracking-wider">
                                    Calculated Total</p>
                                    {{-- get opening balances calculated for the contributing year --}}
                                    @forelse ($openingBalances as $balance)
                                        <p class="text-2xl font-black text-slate-900 dark:text-slate-100">₵{{ number_format($balance->total_amount, 2) }}</p>
                                    @empty
                                        <p class="text-2xl font-black text-slate-900 dark:text-slate-100">₵0.00</p>
                                    @endforelse
                                    {{-- @if(isset($openingBalances->total_amount))
                                        <p class="text-2xl font-black text-slate-900 dark:text-slate-100">₵{{ number_format($openingBalances->total_amount, 2) }}</p>
                                    @else
                                        <p class="text-2xl font-black text-slate-900 dark:text-slate-100">₵0.00</p>
                                    @endif --}}
                                <p class="text-xs text-slate-400">Employee + Employer share</p>
                            </div>
                            {{-- <div class="grid grid-cols-2 gap-4">
                                <div
                                    class="p-4 bg-green-50 dark:bg-green-900/10 rounded-lg flex flex-col gap-1 border border-green-100 dark:border-green-900/30">
                                    <p class="text-[10px] text-green-700 dark:text-green-400 font-bold uppercase">Employee
                                    </p>
                                    <p class="text-lg font-bold text-green-800 dark:text-green-300">₵0.00</p>
                                </div>
                                <div
                                    class="p-4 bg-primary/5 dark:bg-primary/10 rounded-lg flex flex-col gap-1 border border-primary/10">
                                    <p class="text-[10px] text-primary font-bold uppercase">Employer</p>
                                    <p class="text-lg font-bold text-primary">₵0.00</p>
                                </div>
                            </div>
                            <div class="space-y-3 mt-2">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-500 dark:text-slate-400">Entries This Session</span>
                                    <span class="font-bold text-slate-900 dark:text-slate-100">0</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-500 dark:text-slate-400">Pending Approval</span>
                                    <span class="font-bold text-accent-gold">1</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-500 dark:text-slate-400">Approved Today</span>
                                    <span class="font-bold text-green-600">1</span>
                                </div>
                            </div> --}}
                            {{-- <button
                                class="w-full mt-2 py-3 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-lg text-sm font-bold hover:opacity-90 transition-opacity">
                                Generate Reconciliation Report
                            </button> --}}
                        </div>
                    </div>

                    <!-- Validation Tips -->
                    <div
                        class="bg-amber-50 dark:bg-amber-900/10 p-5 rounded-xl border border-amber-200 dark:border-amber-800/30 flex items-start gap-4">
                        <div class="size-9 rounded-lg bg-amber-400 text-white flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[18px]">tips_and_updates</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <h4 class="text-slate-900 dark:text-slate-100 font-bold text-sm">Manual Entry Tips</h4>
                            <ul class="text-slate-500 dark:text-slate-400 text-xs space-y-1 mt-1 list-disc list-inside">
                                {{-- <li>Mandatory contributions are 5% employee / 10% employer.</li> --}}
                                <li>Always attach a payment reference for audit trails.</li>
                                {{-- <li>Arrears must be approved by a fund administrator.</li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Manual Entries Table -->
            <div
                class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="flex flex-col gap-6">

                    <div
                        class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                        <h3 class="text-slate-900 dark:text-slate-100 text-lg font-bold">Recent Manual Entries</h3>
                        <button class="text-primary text-sm font-bold hover:underline">View All</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-800/50">
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Member</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Period</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Type</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Total</th>
                                     <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Date</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">
                                        Actions</th>
                                </tr>
                            </thead>
                            @forelse ($recentContributions as $contrib)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="size-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold">
                                                {{ substr($contrib->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                                    {{ $contrib->name }}</p>
                                                <p class="text-xs text-slate-400">{{ $contrib->staff_no }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-500">
                                        {{ date('M Y', mktime(0, 0, 0, $contrib->payroll_month, 1, $contrib->payroll_year)) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-500">{{ $contrib->contribution_type }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-slate-900 dark:text-slate-100">
                                        ₵{{ number_format($contrib->contribution_amount, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-500">
                                            {{ date('M d, Y', strtotime($contrib->created_at)) }}
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClass = match ($contrib->status) {
                                                'approved' => 'green',
                                                'pending' => 'yellow',
                                                'rejected' => 'red',
                                                'deleted' => 'gray',
                                                default => 'blue',
                                        }; @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $statusClass }}-100 text-{{ $statusClass }}-800 dark:bg-{{ $statusClass }}-900/30 dark:text-{{ $statusClass }}-400 capitalize">
                                            {{ $contrib->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right flex justify-end gap-2">
                                        <a href="{{ route('payroll-contribution.edit', $contrib) }}"
                                            class="text-slate-400 hover:text-primary" title="Edit">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </a>
                                        <form action="{{ route('contributions.destroy', $contrib) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Delete this contribution?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-red-500"
                                                title="Delete">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                        <span
                                            class="material-symbols-outlined text-4xl block mb-2 opacity-50">payments</span>
                                        No contributions yet. Create your first one!
                                    </td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== BULK UPLOAD TAB ===================== -->
    <div id="panel-bulk" class="tab-panel hidden px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Upload Section -->
            <div class="lg:col-span-2 flex flex-col gap-6">
<form action="{{ route('payroll-uploads.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                    @csrf
                    <input type="file" name="payroll_file" id="file-input" accept=".csv,.xlsx,.xls" class="hidden" required>
                    <div
                        class="flex flex-col items-center gap-6 rounded-xl border-2 border-dashed border-primary/30 bg-primary/5 px-6 py-16 hover:bg-primary/10 transition-all cursor-pointer group"
                        id="drop-zone">
                        <div
                            class="size-16 rounded-full bg-primary/20 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[32px]">upload_file</span>
                        </div>
                        <div class="flex max-w-[480px] flex-col items-center gap-2">
                            <p
                                class="text-slate-900 dark:text-slate-100 text-lg font-bold leading-tight tracking-tight text-center">
                                Drag and drop payroll files
                            </p>
                            <p id="file-info"
                                class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal max-w-[480px] text-center">
                                Support for .csv, .xlsx, and .xls files up to 10MB
                            </p>
                        </div>
                        <button type="button"
                            class="flex min-w-[140px] items-center justify-center rounded-lg h-11 px-6 bg-primary text-white text-sm font-bold tracking-tight hover:bg-primary/90 transition-all"
                            id="browse-btn">
                            Browse Files
                        </button>
                    </div>
                    <div id="upload-progress" class="mt-4 hidden">
                        <div class="w-full bg-slate-200 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full transition-all" style="width: 0%"></div>
                        </div>
                        <p class="text-sm text-slate-500 mt-1">Uploading...</p>
                    </div>
                </form>
                <!-- Recent Uploads Table -->
                <div
                    class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                    <div
                        class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                        <h3 class="text-slate-900 dark:text-slate-100 text-lg font-bold">Recent Uploads</h3>
                        <a href="{{ route('payroll-uploads.index') }}" class="text-primary text-sm font-bold hover:underline">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-800/50">
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        File Name</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Date</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Status</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Records</th>
                                    <th
                                        class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse ($payrollUploads as $upload)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <span class="material-symbols-outlined text-green-600">description</span>
                                                <span
                                                    class="text-sm font-medium text-slate-900 dark:text-slate-100 truncate max-w-48">{{ $upload->filename }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-500">{{ $upload->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4">
                                            @php $statusClass = match($upload->status) { 'success' => 'green', 'failed' => 'red', 'processing' => 'blue', default => 'gray' }; @endphp
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $statusClass }}-100 text-{{ $statusClass }}-800 dark:bg-{{ $statusClass }}-900/30 dark:text-{{ $statusClass }}-400 capitalize">
                                                {{ ucfirst($upload->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-500 font-medium">{{ $upload->records_count ?? 0 }}</td>
                                        <td class="px-6 py-4 text-right flex gap-1">
                                            <a href="#" class="text-slate-400 hover:text-primary p-1" title="View">
                                                <span class="material-symbols-outlined text-sm">visibility</span>
                                            </a>
                                            @if($upload->notes)
                                            <button class="text-slate-400 hover:text-accent-gold p-1" title="Details">
                                                <span class="material-symbols-outlined text-sm">info</span>
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                            <span class="material-symbols-outlined text-4xl block mb-2 opacity-50">cloud_upload</span>
                                            No payroll uploads yet. Upload your first file!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Right: Reconciliation Summary -->
            <div class="flex flex-col gap-6">
                <div
                    class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <h3 class="text-slate-900 dark:text-slate-100 text-lg font-bold mb-4">Reconciliation Summary</h3>
                    <div class="flex flex-col gap-4">
                        <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg flex flex-col gap-1">
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium uppercase tracking-wider">
                                Total Contribution This Period</p>
                            <p class="text-2xl font-black text-slate-900 dark:text-slate-100">$245,890.00</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="p-4 bg-green-50 dark:bg-green-900/10 rounded-lg flex flex-col gap-1 border border-green-100 dark:border-green-900/30">
                                <p class="text-[10px] text-green-700 dark:text-green-400 font-bold uppercase">Employer
                                    Share</p>
                                <p class="text-lg font-bold text-green-800 dark:text-green-300">$122,945</p>
                            </div>
                            <div
                                class="p-4 bg-primary/5 dark:bg-primary/10 rounded-lg flex flex-col gap-1 border border-primary/10">
                                <p class="text-[10px] text-primary font-bold uppercase">Employee Share</p>
                                <p class="text-lg font-bold text-primary">$122,945</p>
                            </div>
                        </div>
                        <div class="mt-2 space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 dark:text-slate-400">Total Members Tracked</span>
                                <span class="font-bold text-slate-900 dark:text-slate-100">1,240</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 dark:text-slate-400">New Enrollments</span>
                                <span class="font-bold text-primary">+12</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 dark:text-slate-400">Pending Clarification</span>
                                <span class="font-bold text-accent-gold">3</span>
                            </div>
                            <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-full bg-slate-200 dark:bg-slate-700 h-2 rounded-full overflow-hidden">
                                        <div class="bg-primary h-full w-[85%] rounded-full"></div>
                                    </div>
                                    <span
                                        class="text-xs font-bold text-slate-900 dark:text-slate-100 whitespace-nowrap">85%
                                        Processed</span>
                                </div>
                            </div>
                        </div>
                        {{-- <button
                            class="w-full mt-2 py-3 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-lg text-sm font-bold hover:opacity-90 transition-opacity">
                            Generate Reconciliation Report
                        </button> --}}
                    </div>
                </div>
                <!-- Template Download -->
                <div
                    class="bg-primary/10 dark:bg-primary/20 p-6 rounded-xl border border-primary/20 flex items-start gap-4">
                    <div class="size-10 rounded-lg bg-primary text-white flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">download</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h4 class="text-slate-900 dark:text-slate-100 font-bold text-sm">Need the upload template?</h4>
                        <p class="text-slate-500 dark:text-slate-400 text-xs">Download our standardized CSV/Excel template
                            to ensure correct formatting.</p>
                        <a class="text-primary text-xs font-bold mt-2 flex items-center gap-1 hover:underline"
                            href="#">
                            Download Template.xlsx
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        function switchTab(tab) {
            // Toggle panels
            document.getElementById('panel-manual').classList.toggle('hidden', tab !== 'manual');
            document.getElementById('panel-bulk').classList.toggle('hidden', tab !== 'bulk');

            // Toggle tab active styles
            const tabs = {
                manual: document.getElementById('tab-manual'),
                bulk: document.getElementById('tab-bulk')
            };
            Object.entries(tabs).forEach(([key, el]) => {
                const isActive = key === tab;
                el.classList.toggle('border-primary', isActive);
                el.classList.toggle('text-primary', isActive);
                el.classList.toggle('border-transparent', !isActive);
                el.classList.toggle('text-slate-500', !isActive);
                el.classList.toggle('dark:text-slate-400', !isActive);
            });
        }

        // File Upload JS
        document.addEventListener('DOMContentLoaded', function() {
            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('file-input');
            const browseBtn = document.getElementById('browse-btn');
            const fileInfo = document.getElementById('file-info');
            const uploadForm = document.getElementById('upload-form');
            const uploadProgress = document.getElementById('upload-progress');

            // Browse click
            browseBtn.addEventListener('click', () => fileInput.click());

            // Input change
            fileInput.addEventListener('change', handleFiles);

            // Drag events
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.add('bg-primary/20'), false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.remove('bg-primary/20'), false);
            });

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                handleFiles();
            }

            function handleFiles() {
                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    if (file.size > 10 * 1024 * 1024) {
                        alert('File too large. Max 10MB.');
                        return;
                    }
                    fileInfo.textContent = `${file.name} (${(file.size/1024/1024).toFixed(1)}MB)`;
                    dropZone.classList.add('border-primary', 'bg-primary/10');
                }
            }

            // Form submit with progress
            uploadForm.addEventListener('submit', function(e) {
                if (!fileInput.files.length) {
                    e.preventDefault();
                    alert('Please select a file');
                    return;
                }

                uploadProgress.classList.remove('hidden');
                const progressBar = uploadProgress.querySelector('div div');
                let width = 0;
                const interval = setInterval(() => {
                    width += 10;
                    progressBar.style.width = width + '%';
                    if (width >= 90) clearInterval(interval);
                }, 200);

                // Submit normally (Laravel handles redirect)
            });
        });
    </script>
@endsection
