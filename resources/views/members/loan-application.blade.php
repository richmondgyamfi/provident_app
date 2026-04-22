@extends('layouts.app')

@section('title', 'Loan')

@section('content')
    <form id="loan-form" method="POST" action="{{ route('loans.store') }}" enctype="multipart/form-data"
        class="p-4 sm:p-8 space-y-6 sm:space-y-8">
        @csrf

        <!-- ── Page Heading ──────────────────────────────── -->
        <div class="flex flex-col gap-2">
            <h1 class="text-slate-900 dark:text-slate-100 text-3xl sm:text-4xl font-black leading-tight tracking-[-0.033em]">
                New Loan Application
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-base font-normal">
                Complete the steps below to submit your loan request. Approval typically takes 3–5 business days.
            </p>
        </div>

        <!-- ── Progress Bar ──────────────────────────────── -->
        <div
            class="bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex flex-wrap justify-between items-end gap-2 mb-4">
                <div class="flex flex-col gap-1">
                    <p id="step-label" class="text-accent-red text-sm font-bold uppercase tracking-wider">Step 1 of 4</p>
                    <h3 id="step-title" class="text-slate-900 dark:text-slate-100 text-xl font-bold">Loan Details</h3>
                </div>
                <p id="step-pct" class="text-slate-900 dark:text-slate-100 text-sm font-bold">25% Complete</p>
            </div>
            <div class="w-full bg-slate-100 dark:bg-slate-800 h-3 rounded-full overflow-hidden">
                <div id="progress-bar" class="bg-primary h-full transition-all duration-500" style="width: 25%;"></div>
            </div>
            <div class="flex flex-wrap justify-between gap-y-2 mt-4">
                <div id="ind-1" class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    <span class="text-xs font-semibold">Details</span>
                </div>
                <div id="ind-2" class="flex items-center gap-2 text-slate-400">
                    <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                    <span class="text-xs font-semibold">Calculation</span>
                </div>
                <div id="ind-3" class="flex items-center gap-2 text-slate-400">
                    <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                    <span class="text-xs font-semibold">Documents</span>
                </div>
                <div id="ind-4" class="flex items-center gap-2 text-slate-400">
                    <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                    <span class="text-xs font-semibold">Terms</span>
                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════════════════════
                 STEP 1 – Loan Details
            ══════════════════════════════════════════════════ -->
        <div id="step-panel-1"
            class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="p-5 sm:p-8 border-b border-slate-200 dark:border-slate-800">
                <h2
                    class="text-slate-900 dark:text-slate-100 text-xl sm:text-[22px] font-bold leading-tight tracking-[-0.015em] mb-6">
                    Enter Loan Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                    <!-- Loan Amount -->
                    <div class="flex flex-col gap-2">
                        <label class="text-slate-900 dark:text-slate-100 text-sm font-bold">Requested Loan Amount</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">₵</span>
                            <input id="loan-amount" name="amount" value="{{ old('amount') }}"
                                class="form-input flex w-full rounded-lg border border-slate-200 dark:border-slate-800 bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 focus:border-primary focus:ring-1 focus:ring-primary h-14 pl-8 pr-4 text-base font-medium"
                                placeholder="0.00" type="number" oninput="recalc()" />
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 italic">
                            Maximum eligible: <span class="font-bold text-slate-700 dark:text-slate-300">₵50,000.00</span>
                        </p>
                    </div>
                    <!-- Loan Type -->
                    <div class="flex flex-col gap-2">
                        <label class="text-slate-900 dark:text-slate-100 text-sm font-bold">Loan Type</label>
                        <select id="loan-type" name="loan_type"
                            class="form-select flex w-full rounded-lg border border-slate-200 dark:border-slate-800 bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 focus:border-primary focus:ring-1 focus:ring-primary h-14 px-4 text-base font-medium"
                            onchange="recalc()">
                            @if ($staffmember)
                            <option value="member">Member Loan</option>
                            @else
                            <option value="non-member">Non-Member Loan</option>
                            @endif
                        </select>
                    </div>
                    <!-- Term -->
                    <div class="flex flex-col gap-2">
                        <label class="text-slate-900 dark:text-slate-100 text-sm font-bold">Repayment Period
                            (Months)</label>
                        <input id="loan-term" name="{{ old('term_months') }}"
                            class="form-input flex w-full rounded-lg border border-slate-200 dark:border-slate-800 bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 focus:border-primary focus:ring-1 focus:ring-primary h-14 px-4 text-base font-medium"
                            max="48" min="6" placeholder="e.g. 12" type="number" oninput="recalc()" />
                        <p class="text-xs text-slate-500 dark:text-slate-400">Min: 6 months / Max: 48 months</p>
                    </div>
                    <!-- Purpose -->
                    <div class="flex flex-col gap-2">
                        <label class="text-slate-900 dark:text-slate-100 text-sm font-bold">Purpose of Loan</label>
                        <input id="loan-purpose" name="purpose" value="{{ old('purpose') }}"
                            class="form-input flex w-full rounded-lg border border-slate-200 dark:border-slate-800 bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 focus:border-primary focus:ring-1 focus:ring-primary h-14 px-4 text-base font-medium"
                            placeholder="Brief description" type="text" />
                    </div>
                </div>
            </div>

            <!-- Preview calculation banner -->
            <div
                class="bg-primary/5 p-5 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 border-b border-slate-200 dark:border-slate-800">
                <div class="flex items-center gap-4">
                    <div class="size-12 rounded-full bg-primary flex items-center justify-center text-white shrink-0">
                        <span class="material-symbols-outlined">calculate</span>
                    </div>
                    <div>
                        <h4 class="text-slate-900 dark:text-slate-100 font-bold">Preview Calculation</h4>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">Estimated figures based on current interest
                            rates.</p>
                    </div>
                </div>
                <div class="flex gap-6 sm:gap-8 w-full sm:w-auto">
                    <div class="text-left sm:text-right">
                        <p class="text-xs text-slate-500 dark:text-slate-400 uppercase font-bold tracking-wider">Interest
                            Rate</p>
                        @if ($staffmember)
                        <p id="preview-rate" class="text-xl font-black text-accent-red">14% p.a.</p>
                        @else
                        <p id="preview-rate" class="text-xl font-black text-accent-red">16% p.a.</p>
                        @endif
                    </div>
                    <div class="text-left sm:text-right border-l border-slate-200 dark:border-slate-800 pl-6 sm:pl-8">
                        <p class="text-xs text-slate-500 dark:text-slate-400 uppercase font-bold tracking-wider">Monthly Pay
                        </p>
                        <p id="preview-monthly" class="text-xl font-black text-slate-900 dark:text-slate-100">₵0.00</p>
                    </div>
                </div>
            </div>

            <div class="p-5 sm:p-8 flex flex-wrap justify-between items-center gap-4 bg-slate-50 dark:bg-slate-900/50">
                <button type="button" onclick="goToStep(null)"
                    class="flex items-center justify-center px-6 h-12 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
                    Cancel
                </button>
                <button type="button" onclick="goToStep(2)"
                    class="flex items-center justify-center px-6 sm:px-8 h-12 rounded-lg bg-primary text-white font-bold hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">
                    Save &amp; Next
                    <span class="material-symbols-outlined ml-2 text-[20px]">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- ══════════════════════════════════════════════════
                 STEP 2 – Calculation
            ══════════════════════════════════════════════════ -->
        <div id="step-panel-2" class="hidden space-y-6">

            <div
                class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="p-5 sm:p-8 border-b border-slate-200 dark:border-slate-800">
                    <h2 class="text-slate-900 dark:text-slate-100 text-xl sm:text-[22px] font-bold mb-1">Loan Calculation
                        Breakdown</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Review the full repayment schedule before
                        proceeding.</p>
                </div>

                <!-- Summary Cards -->
                <div
                    class="p-5 sm:p-8 grid grid-cols-2 md:grid-cols-4 gap-4 border-b border-slate-200 dark:border-slate-800">
                    <div class="flex flex-col gap-1 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Loan Amount</p>
                        <p id="calc-principal" class="text-xl font-black text-slate-900 dark:text-slate-100">₵0.00</p>
                    </div>
                    <div class="flex flex-col gap-1 p-4 bg-primary/5 rounded-xl border border-primary/10">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-primary">Interest Rate</p>
                        @if ($staffmember)
                        <p id="calc-rate" class="text-xl font-black text-primary">14% p.a.</p>
                        @else
                        <p id="calc-rate" class="text-xl font-black text-primary">16% p.a.</p>
                        @endif
                    </div>
                    <div class="flex flex-col gap-1 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Monthly Payment</p>
                        <p id="calc-monthly" class="text-xl font-black text-slate-900 dark:text-slate-100">₵0.00</p>
                    </div>
                    <div class="flex flex-col gap-1 p-4 bg-accent-red/5 rounded-xl border border-accent-red/10">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-accent-red">Total Repayable</p>
                        <p id="calc-total" class="text-xl font-black text-accent-red">₵0.00</p>
                    </div>
                </div>

                <!-- Extra details row -->
                <div
                    class="px-5 sm:px-8 py-5 grid grid-cols-1 sm:grid-cols-3 gap-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/30">
                    <div class="flex justify-between sm:flex-col gap-1">
                        <span class="text-xs text-slate-500 dark:text-slate-400">Repayment Period</span>
                        <span id="calc-term" class="text-sm font-bold text-slate-900 dark:text-slate-100">— months</span>
                    </div>
                    <div class="flex justify-between sm:flex-col gap-1">
                        <span class="text-xs text-slate-500 dark:text-slate-400">Total Interest Charged</span>
                        <span id="calc-interest" class="text-sm font-bold text-slate-900 dark:text-slate-100">₵0.00</span>
                    </div>
                    <div class="flex justify-between sm:flex-col gap-1">
                        <span class="text-xs text-slate-500 dark:text-slate-400">Loan Type</span>
                        <span id="calc-type" class="text-sm font-bold text-slate-900 dark:text-slate-100">—</span>
                    </div>
                </div>

                <!-- Amortisation table -->
                <div class="p-5 sm:p-8">
                    <h3 class="text-slate-900 dark:text-slate-100 font-bold mb-4">Repayment Schedule</h3>
                    <div class="overflow-x-auto rounded-lg border border-slate-200 dark:border-slate-800">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-800/50">
                                    <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Month</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Opening Balance</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Principal</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Interest</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Monthly Payment</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Closing Balance</th>
                                </tr>
                            </thead>
                            <tbody id="amort-table" class="divide-y divide-slate-100 dark:divide-slate-800">
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-slate-400 text-sm italic">
                                        Enter loan details in Step 1 to generate the repayment schedule.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-xs text-slate-400 mt-3 italic">* Figures shown are estimates. Final amounts are subject
                        to fund approval and disbursement date.</p>
                </div>

                <div
                    class="p-5 sm:p-8 flex flex-wrap justify-between items-center gap-4 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-200 dark:border-slate-800">
                    <button onclick="goToStep(1)"
                        class="flex items-center justify-center px-6 h-12 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
                        <span class="material-symbols-outlined mr-2 text-[20px]">arrow_back</span>Back
                    </button>
                    <button type="button" onclick="goToStep(3)"
                        class="flex items-center justify-center px-6 sm:px-8 h-12 rounded-lg bg-primary text-white font-bold hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">
                        Save &amp; Next
                        <span class="material-symbols-outlined ml-2 text-[20px]">arrow_forward</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════════════════════
                 STEP 3 – Documents
            ══════════════════════════════════════════════════ -->
        <div id="step-panel-3" class="hidden space-y-6">

            <div
                class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="p-5 sm:p-8 border-b border-slate-200 dark:border-slate-800">
                    <h2 class="text-slate-900 dark:text-slate-100 text-xl sm:text-[22px] font-bold mb-1">Supporting
                        Documents</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Upload the required documents to support your
                        loan application. Accepted formats: PDF, JPG, PNG (max 5MB each).</p>
                </div>

                <div
                    class="p-5 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-slate-200 dark:border-slate-800">

                    <!-- Required document uploads -->
                    @php
                        $docs = [
                            [
                                'id' => 'doc-id',
                                'label' => 'National ID / Passport',
                                'desc' => 'A valid government-issued photo ID.',
                                'icon' => 'badge',
                                'required' => true,
                            ],
                            // [
                            //     'id' => 'doc-payslip',
                            //     'label' => 'Latest 3 Pay Slips',
                            //     'desc' => 'Signed payslips from the last three months.',
                            //     'icon' => 'receipt_long',
                            //     'required' => true,
                            // ],
                            // [
                            //     'id' => 'doc-letter',
                            //     'label' => 'Employment / Confirmation Letter',
                            //     'desc' => 'Letter from your employer confirming employment.',
                            //     'icon' => 'description',
                            //     'required' => true,
                            // ],
                            // [
                            //     'id' => 'doc-bank',
                            //     'label' => 'Bank Statement (3 months)',
                            //     'desc' => 'Official statement from your bank.',
                            //     'icon' => 'account_balance',
                            //     'required' => true,
                            // ],
                            // [
                            //     'id' => 'doc-purpose',
                            //     'label' => 'Proof of Purpose (if applicable)',
                            //     'desc' => 'Quotation, invoice, or supporting evidence.',
                            //     'icon' => 'attach_file',
                            //     'required' => false,
                            // ],
                            // [
                            //     'id' => 'doc-other',
                            //     'label' => 'Any Other Supporting Document',
                            //     'desc' => 'Optional additional supporting files.',
                            //     'icon' => 'folder_open',
                            //     'required' => false,
                            // ],
                        ];
                    @endphp

                    @foreach ($docs as $doc)
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2">
                                <label for="{{ $doc['id'] }}"
                                    class="text-slate-900 dark:text-slate-100 text-sm font-bold">
                                    {{ $doc['label'] }}
                                </label>
                                @if ($doc['required'])
                                    <span
                                        class="text-[10px] font-bold text-white bg-accent-red px-1.5 py-0.5 rounded">Required</span>
                                @else
                                    <span
                                        class="text-[10px] font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 px-1.5 py-0.5 rounded">Optional</span>
                                @endif
                            </div>
                            <label for="{{ $doc['id'] }}"
                                class="doc-drop-zone flex items-center gap-4 p-4 rounded-lg border-2 border-dashed border-slate-200 dark:border-slate-700 hover:border-primary/50 hover:bg-primary/5 cursor-pointer transition-all group"
                                ondragover="event.preventDefault()" ondrop="handleDrop(event, '{{ $doc['id'] }}')">
                                <div
                                    class="size-10 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 group-hover:text-primary group-hover:bg-primary/10 transition-colors shrink-0">
                                    <span class="material-symbols-outlined text-[22px]">{{ $doc['icon'] }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $doc['desc'] }}</p>
                                    <p id="{{ $doc['id'] }}-name"
                                        class="text-xs font-semibold text-primary mt-0.5 hidden"></p>
                                </div>
                                <span
                                    class="material-symbols-outlined text-slate-300 group-hover:text-primary text-[20px] shrink-0">upload</span>
                                <input type="file" id="{{ $doc['id'] }}" class="hidden"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    onchange="showFileName(this, '{{ $doc['id'] }}-name')" />
                            </label>
                        </div>
                    @endforeach
                </div>

                <!-- Upload checklist -->
                <div class="p-5 sm:p-8 bg-slate-50 dark:bg-slate-800/30 border-b border-slate-200 dark:border-slate-800">
                    <h3 class="text-slate-900 dark:text-slate-100 font-bold text-sm mb-3">Document Checklist</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach (['File size must not exceed 5MB per document.', 'All documents must be clear and legible.', 'PDFs must not be password-protected.', 'Scanned copies must be in colour.', 'Bank statements must show your name and account number.', 'Documents must be dated within the last 3 months where applicable.'] as $tip)
                            <div class="flex items-start gap-2">
                                <span
                                    class="material-symbols-outlined text-primary text-[16px] mt-0.5 shrink-0">check_circle</span>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $tip }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="p-5 sm:p-8 flex flex-wrap justify-between items-center gap-4 bg-slate-50 dark:bg-slate-900/50">
                    <button type="button" onclick="goToStep(2)"
                        class="flex items-center justify-center px-6 h-12 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
                        <span class="material-symbols-outlined mr-2 text-[20px]">arrow_back</span>Back
                    </button>
                    <button type="button" onclick="goToStep(4)"
                        class="flex items-center justify-center px-6 sm:px-8 h-12 rounded-lg bg-primary text-white font-bold hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">
                        Save &amp; Next
                        <span class="material-symbols-outlined ml-2 text-[20px]">arrow_forward</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════════════════════
                 STEP 4 – Terms & Submission
            ══════════════════════════════════════════════════ -->
        <div id="step-panel-4" class="hidden space-y-6">

            <div
                class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="p-5 sm:p-8 border-b border-slate-200 dark:border-slate-800">
                    <h2 class="text-slate-900 dark:text-slate-100 text-xl sm:text-[22px] font-bold mb-1">Terms &amp;
                        Conditions</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Please read and accept the terms below before
                        submitting your application.</p>
                </div>

                <!-- Application Summary -->
                <div class="p-5 sm:p-8 border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/30">
                    <h3 class="text-slate-900 dark:text-slate-100 font-bold mb-4">Application Summary</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="flex flex-col gap-0.5">
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Loan Amount</p>
                            <p id="terms-principal" class="text-base font-black text-slate-900 dark:text-slate-100">₵0.00
                            </p>
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Loan Type</p>
                            <p id="terms-type" class="text-base font-black text-slate-900 dark:text-slate-100">—</p>
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Interest Rate</p>
                            @if ($staffmember)
                            <p id="calc-rate" class="text-xl font-black text-primary">14% p.a.</p>
                            @else
                            <p id="calc-rate" class="text-xl font-black text-primary">16% p.a.</p>
                            @endif
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Monthly Payment</p>
                            <p id="terms-monthly" class="text-base font-black text-slate-900 dark:text-slate-100">₵0.00
                            </p>
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Repayment Period</p>
                            <p id="terms-term" class="text-base font-black text-slate-900 dark:text-slate-100">— months
                            </p>
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Total Interest</p>
                            <p id="terms-interest" class="text-base font-black text-slate-900 dark:text-slate-100">₵0.00
                            </p>
                        </div>
                        <div class="md:col-span-2 flex flex-col gap-0.5">
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Total Repayable</p>
                            <p id="terms-total" class="text-base font-black text-accent-red">₵0.00</p>
                        </div>
                    </div>
                </div>

                <!-- Terms scroll box -->
                <div class="p-5 sm:p-8 border-b border-slate-200 dark:border-slate-800">
                    <div
                        class="h-60 overflow-y-auto rounded-lg border border-slate-200 dark:border-slate-700 p-5 bg-slate-50 dark:bg-slate-800/50 text-xs text-slate-600 dark:text-slate-400 leading-relaxed space-y-3">
                        <p class="font-bold text-slate-900 dark:text-slate-100 text-sm">Loan Agreement Terms &amp;
                            Conditions</p>

                        <p><span class="font-semibold text-slate-800 dark:text-slate-200">1. Interest Rates.</span>
                            Personal and Emergency Loans attract an interest rate of <strong>
                            @if ($staffmember)
                            14%
                            @else
                            16%
                            @endif per annum</strong>,
                            calculated on a reducing balance basis. Facility Loans attract an interest rate of <strong>16%
                                per annum</strong> on a reducing balance basis. Rates are set by the Fund and may be
                            reviewed periodically with appropriate member notification.</p>

                        <p><span class="font-semibold text-slate-800 dark:text-slate-200">2. Repayment.</span> Loan
                            repayments shall be deducted at source from the member's monthly salary by the employer and
                            remitted to the Fund not later than the 14th of every month. Failure of the employer to remit
                            deductions does not absolve the member of their repayment obligation.</p>

                        <p><span class="font-semibold text-slate-800 dark:text-slate-200">3. Eligibility.</span> Applicants
                            must have a minimum of 12 months active membership and contributions in good standing.
                            Outstanding loans must be fully settled before a new loan is granted, unless refinancing is
                            approved by the Fund Administrator.</p>

                        <p><span class="font-semibold text-slate-800 dark:text-slate-200">4. Default.</span> A loan is
                            considered in default if two or more consecutive monthly instalments are missed. Upon default,
                            the full outstanding balance becomes immediately due, and the Fund reserves the right to recover
                            arrears from the member's contributions or benefit entitlement.</p>

                        <p><span class="font-semibold text-slate-800 dark:text-slate-200">5. Early Repayment.</span>
                            Members may settle their loan in full or in part at any time without penalty. Partial payments
                            will be applied first to outstanding interest and then to the principal balance.</p>

                        <p><span class="font-semibold text-slate-800 dark:text-slate-200">6. Loan Insurance.</span> All
                            loans above ₵5,000 are covered by the Fund's group loan protection scheme. In the event of death
                            or total permanent disability, the outstanding loan balance shall be waived. A nominal insurance
                            levy may be applied as disclosed in the Loan Offer Letter.</p>

                        <p><span class="font-semibold text-slate-800 dark:text-slate-200">7. Disbursement.</span> Approved
                            loan funds will be disbursed to the member's registered bank account on file within 5 working
                            days of full document submission and credit approval.</p>

                        <p><span class="font-semibold text-slate-800 dark:text-slate-200">8. Disclosure.</span> The Fund
                            may share loan information with relevant regulatory or supervisory bodies as required by law.
                            Members consent to a credit enquiry being conducted as part of the application process.</p>

                        <p><span class="font-semibold text-slate-800 dark:text-slate-200">9. Governing Law.</span> This
                            agreement is governed by the laws of Ghana and disputes shall be subject to the jurisdiction of
                            the courts of Ghana or the appropriate Alternative Dispute Resolution body as determined by the
                            Fund.</p>

                        <p><span class="font-semibold text-slate-800 dark:text-slate-200">10. Amendments.</span> The Fund
                            reserves the right to amend these terms with 30 days' prior notice to members. Continued
                            participation following such notice constitutes acceptance of the revised terms.</p>
                    </div>
                </div>

                <!-- Declarations & Checkboxes -->
                <div class="p-5 sm:p-8 border-b border-slate-200 dark:border-slate-800 space-y-4">
                    <h3 class="text-slate-900 dark:text-slate-100 font-bold">Declaration</h3>

                    @php
                        $declarations = [
                            [
                                'id' => 'chk-read',
                                'text' =>
                                    'I have read and fully understood the loan terms and conditions stated above.',
                            ],
                            [
                                'id' => 'chk-accurate',
                                'text' =>
                                    'I confirm that all information and documents provided in this application are true, accurate, and complete.',
                            ],
                            [
                                'id' => 'chk-deduction',
                                'text' =>
                                    'I authorise the Fund to deduct monthly loan repayments from my salary/contributions as stated in this agreement.',
                            ],
                            [
                                'id' => 'chk-default',
                                'text' =>
                                    'I understand the consequences of default and agree to notify the Fund immediately if I am unable to meet a repayment.',
                            ],
                        ];
                    @endphp

                    @foreach ($declarations as $decl)
                        <label for="{{ $decl['id'] }}" class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" id="{{ $decl['id'] }}"
                                class="mt-0.5 size-4 rounded border-slate-300 text-primary focus:ring-primary cursor-pointer"
                                onchange="checkDeclarations()" />
                            <span
                                class="text-sm text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-slate-100 transition-colors leading-relaxed">
                                {{ $decl['text'] }}
                            </span>
                        </label>
                    @endforeach
                </div>

                <!-- Signature pad placeholder -->
                <div class="p-5 sm:p-8 border-b border-slate-200 dark:border-slate-800">
                    <h3 class="text-slate-900 dark:text-slate-100 font-bold mb-3">Member Signature</h3>
                    <div class="flex flex-col sm:flex-row gap-4 items-start">
                        <label for="chk-signature" class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" id="chk-signature"
                                class="size-4 rounded border-slate-300 text-primary focus:ring-primary cursor-pointer" />
                            <span
                                class="text-sm text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-slate-100 transition-colors">
                                I hereby sign this loan application electronically and agree to all terms stated above.
                            </span>
                        </label>
                        <div class="flex flex-col gap-2 shrink-0">
                            <div class="flex flex-col gap-1">
                                <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Full
                                    Name</label>
                                <input type="text" placeholder="Type your full legal name"
                                    class="h-11 px-4 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition w-64" />
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 shrink-0">
                            <div class="flex flex-col gap-2">
                                <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</label>
                                <input type="date"
                                    class="h-11 px-4 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition w-64"
                                    value="{{ date('Y-m-d') }}" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-8 flex flex-wrap justify-between items-center gap-4 bg-slate-50 dark:bg-slate-900/50">
                    <button type="button" onclick="goToStep(3)"
                        class="flex items-center justify-center px-6 h-12 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
                        <span class="material-symbols-outlined mr-2 text-[20px]">arrow_back</span>Back
                    </button>
                    <button id="submit-btn" disabled form="loan-form" type="submit"
                        class="flex items-center justify-center px-6 sm:px-8 h-12 rounded-lg bg-primary text-white font-bold transition-all shadow-lg shadow-primary/20 disabled:opacity-40 disabled:cursor-not-allowed enabled:hover:bg-primary/90">
                        <span class="material-symbols-outlined mr-2 text-[20px]">send</span>
                        Submit Application
                    </button>
                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════════════════════
                 SUCCESS STATE
            ══════════════════════════════════════════════════ -->
        <div id="step-panel-success" class="hidden">
            <div
                class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="p-10 sm:p-16 flex flex-col items-center gap-6 text-center">
                    <div
                        class="size-20 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                        <span class="material-symbols-outlined text-[44px]">check_circle</span>
                    </div>
                    <div class="flex flex-col gap-2 max-w-md">
                        <h2 class="text-slate-900 dark:text-slate-100 text-2xl font-black">Application Submitted!</h2>
                        <p class="text-slate-500 dark:text-slate-400">Your loan application has been received and is under
                            review. You will be notified within <strong>3–5 business days</strong>.</p>
                    </div>
                    <div
                        class="flex items-center gap-3 px-5 py-3 bg-slate-50 dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700">
                        <span class="material-symbols-outlined text-primary text-[20px]">confirmation_number</span>
                        <div class="text-left">
                            <p class="text-xs text-slate-500 font-medium">Reference Number</p>
                            <p id="ref-number" class="text-sm font-black text-slate-900 dark:text-slate-100">LN-2024-00000
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 justify-center mt-2">
                        <a href="#"
                            class="flex items-center gap-2 px-5 h-11 rounded-lg bg-primary text-white font-bold text-sm hover:bg-primary/90 transition-colors">
                            <span class="material-symbols-outlined text-[18px]">download</span>
                            Download Summary
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 px-5 h-11 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-bold text-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            <span class="material-symbols-outlined text-[18px]">home</span>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Guidance Cards ─────────────────────────────── -->
        <div id="guidance-cards" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <div
                class="flex gap-3 p-4 bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 border-t-4 border-t-accent-gold shadow-sm">
                <span class="material-symbols-outlined text-primary shrink-0">info</span>
                <div>
                    <p class="text-sm font-bold text-slate-900 dark:text-slate-100">Need help?</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Contact fund support for policy clarifications.
                    </p>
                </div>
            </div>
            <div
                class="flex gap-3 p-4 bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 border-t-4 border-t-accent-red shadow-sm">
                <span class="material-symbols-outlined text-primary shrink-0">security</span>
                <div>
                    <p class="text-sm font-bold text-slate-900 dark:text-slate-100">Secure Process</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Your financial data is encrypted and protected.
                    </p>
                </div>
            </div>
            <div
                class="flex gap-3 p-4 bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 border-t-4 border-t-primary shadow-sm">
                <span class="material-symbols-outlined text-primary shrink-0">history</span>
                <div>
                    <p class="text-sm font-bold text-slate-900 dark:text-slate-100">Auto-Save</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Application progress is saved automatically.</p>
                </div>
            </div>
        </div>

        </div>

        <script>
            // ─── State ────────────────────────────────────────────────
            let currentStep = 1;
            const totalSteps = 4;

            const stepMeta = {
                1: {
                    label: 'Loan Details',
                    pct: 25
                },
                2: {
                    label: 'Calculation',
                    pct: 50
                },
                3: {
                    label: 'Documents',
                    pct: 75
                },
                4: {
                    label: 'Terms',
                    pct: 100
                },
            };

            const indicators = ['Details', 'Calculation', 'Documents', 'Terms'];

            // ─── Interest rates ────────────────────────────────────────
            function getRate() {
                const type = document.getElementById('loan-type')?.value;
                return type === 'non-member' ? 16 : 14;
            }

            // ─── PMT calculation (reducing balance / amortising) ───────
            function calcPMT(principal, annualRate, months) {
                if (!principal || !months || months <= 0) return 0;
                const r = (annualRate / 100) / 12;
                if (r === 0) return principal / months;
                return principal * r * Math.pow(1 + r, months) / (Math.pow(1 + r, months) - 1);
            }

            // ─── Format currency ───────────────────────────────────────
            function fmt(n) {
                return '₵' + n.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }

            // ─── Recalculate preview (step 1 banner) ──────────────────
            function recalc() {
                const principal = parseFloat(document.getElementById('loan-amount')?.value) || 0;
                const months = parseInt(document.getElementById('loan-term')?.value) || 0;
                const rate = getRate();
                const monthly = calcPMT(principal, rate, months);

                document.getElementById('preview-rate').textContent = rate + '% p.a.';
                document.getElementById('preview-monthly').textContent = fmt(monthly);
            }

            // ─── Build amortisation table ──────────────────────────────
            function buildAmort(principal, annualRate, months) {
                const tbody = document.getElementById('amort-table');
                tbody.innerHTML = '';

                if (!principal || !months) {
                    tbody.innerHTML =
                        '<tr><td colspan="6" class="px-4 py-8 text-center text-slate-400 text-sm italic">Enter loan details in Step 1 to generate the repayment schedule.</td></tr>';
                    return 0;
                }

                const r = (annualRate / 100) / 12;
                const payment = calcPMT(principal, annualRate, months);
                let balance = principal;
                let totalInterest = 0;

                for (let m = 1; m <= months; m++) {
                    const interest = balance * r;
                    const prinPart = payment - interest;
                    const closing = Math.max(balance - prinPart, 0);
                    totalInterest += interest;

                    const rowClass = m % 2 === 0 ? 'bg-slate-50 dark:bg-slate-800/30' : '';
                    tbody.innerHTML += `
                    <tr class="${rowClass}">
                        <td class="px-4 py-2.5 text-sm text-slate-600 dark:text-slate-400 font-medium">${m}</td>
                        <td class="px-4 py-2.5 text-sm text-slate-900 dark:text-slate-100">${fmt(balance)}</td>
                        <td class="px-4 py-2.5 text-sm text-slate-900 dark:text-slate-100">${fmt(prinPart)}</td>
                        <td class="px-4 py-2.5 text-sm text-accent-red">${fmt(interest)}</td>
                        <td class="px-4 py-2.5 text-sm font-bold text-slate-900 dark:text-slate-100">${fmt(payment)}</td>
                        <td class="px-4 py-2.5 text-sm text-slate-600 dark:text-slate-400">${fmt(closing)}</td>
                    </tr>`;
                    balance = closing;
                }

                return totalInterest;
            }

            // ─── Populate step 2 ──────────────────────────────────────
            function populateCalc() {
                const principal = parseFloat(document.getElementById('loan-amount')?.value) || 0;
                const months = parseInt(document.getElementById('loan-term')?.value) || 0;
                const rate = getRate();
                const monthly = calcPMT(principal, rate, months);
                const interest = buildAmort(principal, rate, months);
                const total = principal + interest;
                const typeLabel = {
                    personal: 'Personal Loan',
                    facility: 'Facility Loan',
                    emergency: 'Emergency Loan'
                };
                const typeSel = document.getElementById('loan-type')?.value;

                document.getElementById('calc-principal').textContent = fmt(principal);
                document.getElementById('calc-rate').textContent = rate + '% p.a.';
                document.getElementById('calc-monthly').textContent = fmt(monthly);
                document.getElementById('calc-total').textContent = fmt(total);
                document.getElementById('calc-term').textContent = months ? months + ' months' : '—';
                document.getElementById('calc-interest').textContent = fmt(interest);
                document.getElementById('calc-type').textContent = typeLabel[typeSel] || '—';
            }

            // ─── Populate step 4 ──────────────────────────────────────
            function populateTerms() {
                const principal = parseFloat(document.getElementById('loan-amount')?.value) || 0;
                const months = parseInt(document.getElementById('loan-term')?.value) || 0;
                const rate = getRate();
                const r = (rate / 100) / 12;
                const monthly = calcPMT(principal, rate, months);
                const interest = months ? (monthly * months - principal) : 0;
                const typeLabel = {
                    personal: 'Personal Loan',
                    facility: 'Facility Loan',
                    emergency: 'Emergency Loan'
                };
                const typeSel = document.getElementById('loan-type')?.value;

                document.getElementById('terms-principal').textContent = fmt(principal);
                document.getElementById('terms-type').textContent = typeLabel[typeSel] || '—';
                document.getElementById('terms-rate').textContent = rate + '% p.a.';
                document.getElementById('terms-monthly').textContent = fmt(monthly);
                document.getElementById('terms-term').textContent = months ? months + ' months' : '—';
                document.getElementById('terms-interest').textContent = fmt(interest);
                document.getElementById('terms-total').textContent = fmt(principal + interest);
            }

            // ─── Navigation ───────────────────────────────────────────
            function goToStep(step) {
                if (step === null) return; // Cancel

                // Hide all panels
                for (let i = 1; i <= totalSteps; i++) {
                    document.getElementById(`step-panel-${i}`).classList.add('hidden');
                }
                document.getElementById('step-panel-success').classList.add('hidden');

                if (step > totalSteps) {
                    // Success state handled by submitApplication()
                    return;
                }

                document.getElementById(`step-panel-${step}`).classList.remove('hidden');
                currentStep = step;

                // Update progress UI
                const meta = stepMeta[step];
                document.getElementById('step-label').textContent = `Step ${step} of ${totalSteps}`;
                document.getElementById('step-title').textContent = meta.label;
                document.getElementById('step-pct').textContent = meta.pct + '% Complete';
                document.getElementById('progress-bar').style.width = meta.pct + '%';

                // Update step indicators
                indicators.forEach((name, idx) => {
                    const el = document.getElementById(`ind-${idx + 1}`);
                    const icon = el.querySelector('.material-symbols-outlined');
                    if (idx + 1 < step) {
                        el.className = 'flex items-center gap-2 text-green-600';
                        icon.textContent = 'check_circle';
                    } else if (idx + 1 === step) {
                        el.className = 'flex items-center gap-2 text-primary';
                        icon.textContent = 'check_circle';
                    } else {
                        el.className = 'flex items-center gap-2 text-slate-400';
                        icon.textContent = 'radio_button_unchecked';
                    }
                });

                // Populate data for step-specific screens
                if (step === 2) populateCalc();
                if (step === 4) populateTerms();

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            // ─── Declarations gate ────────────────────────────────────
            function checkDeclarations() {
                const ids = ['chk-read', 'chk-accurate', 'chk-deduction', 'chk-default'];
                const allChecked = ids.every(id => document.getElementById(id)?.checked);
                document.getElementById('submit-btn').disabled = !allChecked;
            }

            // ─── Submit ───────────────────────────────────────────────
            function submitApplication() {
                document.getElementById('loan-form').submit();
            }

            // ─── File upload helpers ───────────────────────────────────
            function showFileName(input, labelId) {
                const label = document.getElementById(labelId);
                if (input.files && input.files[0]) {
                    label.textContent = '✓ ' + input.files[0].name;
                    label.classList.remove('hidden');
                    input.closest('.doc-drop-zone').classList.add('border-primary', 'bg-primary/5');
                }
            }

            function handleDrop(event, inputId) {
                event.preventDefault();
                const input = document.getElementById(inputId);
                if (event.dataTransfer.files.length) {
                    input.files = event.dataTransfer.files;
                    showFileName(input, inputId + '-name');
                }
            }

            // Init preview
            recalc();
        </script>
    @endsection
