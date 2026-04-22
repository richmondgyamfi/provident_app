@extends('layouts.app')

@section('title', 'Withdrawal Request')

@section('content')
    <div class="mb-10">
        <h1 class="text-4xl font-black tracking-tighter text-on-surface uppercase mb-2">Withdrawal
            Request</h1>
        <p class="text-on-surface-variant font-medium">Lodge a formal request for provident fund
            disbursement.</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-7 space-y-8">
            <div class="bg-surface-container-lowest p-8 rounded shadow-sm border-l-4 border-primary">
                <h2 class="text-xs font-bold uppercase tracking-widest text-primary mb-6">Disbursement
                    Details</h2>
<form method="POST" action="{{ route('withdrawals.store') }}" class="space-y-6">
    @csrf
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Withdrawal
                            Amount (GHS)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-slate-400">GHS</span>
                        <input name="amount"
                                class="w-full pl-8 pr-4 py-4 bg-surface border-none focus:ring-2 focus:ring-primary rounded font-bold text-2xl text-on-surface"
                                placeholder="0.00" type="number" step="0.01" required />
                        </div>
                        <p class="text-xs text-slate-400 mt-1 italic">Minimum withdrawal amount is
                            GHS 0</p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Reason
                            for Withdrawal</label>
                        <select name="reason" required
                            class="w-full px-4 py-4 bg-surface border-none focus:ring-2 focus:ring-primary rounded font-bold text-on-surface appearance-none">
                            <option disabled="" selected="" value="">Select a reason...
                            </option>
                            <option value="retirement">Retirement (Age 60+)</option>
                            <option value="housing">Housing/Mortgage Assistance</option>
                            <option value="education">Higher Education Support</option>
                            <option value="medical">Critical Medical Expense</option>
                            <option value="emigration">Permanent Emigration</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Supporting
                            Statement</label>
                        <textarea
                            class="w-full px-4 py-4 bg-surface border-none focus:ring-2 focus:ring-primary rounded font-medium text-on-surface"
                            placeholder="Provide additional details regarding your request..." rows="4"></textarea>
                    </div>
                    <div class="pt-4 flex flex-col sm:flex-row gap-4">
                        <button
                            class="flex-1 bg-primary text-white font-black py-4 rounded shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all uppercase tracking-widest text-sm"
                            type="submit">Submit Request</button>
                        <button
                            class="flex-1 bg-surface-container-high text-on-surface font-black py-4 rounded hover:bg-surface-container-highest transition-all uppercase tracking-widest text-sm"
                            type="button">Cancel</button>
                    </div>
                </form>
            </div>
            <!-- Guidelines & Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-surface-container-lowest p-6 rounded shadow-sm border-l-4 border-secondary">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="material-symbols-outlined text-secondary">event_available</span>
                        <h3 class="text-xs font-black uppercase tracking-widest text-on-surface">
                            Processing Timeline</h3>
                    </div>
                    <ul class="text-sm space-y-3 text-on-surface-variant font-medium">
                        <li class="flex justify-between"><span>Submission Audit</span> <span
                                class="font-bold text-on-surface">24 Hours</span></li>
                        <li class="flex justify-between"><span>Trustee Approval</span> <span
                                class="font-bold text-on-surface">3-5 Days</span></li>
                        <li class="flex justify-between"><span>Disbursement</span> <span
                                class="font-bold text-on-surface">7-10 Days</span></li>
                    </ul>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded shadow-sm border-l-4 border-secondary">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="material-symbols-outlined text-secondary">gavel</span>
                        <h3 class="text-xs font-black uppercase tracking-widest text-on-surface">
                            Retirement Rules</h3>
                    </div>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Standard retirement age is <span class="font-bold text-on-surface">60</span>.
                        Early withdrawal (Age 50-59) may incur a <span class="font-bold text-error">15%
                            penalty</span> on the total principal.
                    </p>
                </div>
            </div>
        </div>
        <!-- Sidebar Info Section -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Balance Card -->
            <div class="bg-blue-900 text-white p-8 rounded-lg shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16">
                </div>
                <div class="relative z-10">
                    <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-blue-300 mb-2">
                        Available for Withdrawal</h3>
                    <div class="text-5xl font-black tracking-tighter mb-4">GHS 0</div>
                    <div class="flex items-center gap-2 text-blue-200 text-sm">
                        <span class="material-symbols-outlined text-sm">lock</span>
                        <span>Total Account Balance: GHS 0</span>
                    </div>
                </div>
            </div>
            <!-- Tax & Fee Summary -->
            <div class="bg-surface-container-lowest p-8 rounded shadow-sm">
                <h2 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-6">Financial
                    Impact Summary</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                        <div>
                            <p class="font-bold text-on-surface">Withholding Tax</p>
                            <p class="text-xs text-slate-400 italic">Estimated (10% standard)</p>
                        </div>
                        <p class="font-bold text-error text-lg">GHS 0</p>
                    </div>
                    <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                        <div>
                            <p class="font-bold text-on-surface">Processing Fee</p>
                            <p class="text-xs text-slate-400 italic">Fixed Institutional Cost</p>
                        </div>
                        <p class="font-bold text-on-surface text-lg">GHS 0</p>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <div>
                            <p class="font-black text-on-surface uppercase tracking-tight">Net Payout
                            </p>
                            <p class="text-xs text-slate-400">Total estimated credit</p>
                        </div>
                        <p class="font-black text-blue-700 text-2xl">GHS 0</p>
                    </div>
                </div>
                <div class="mt-8 p-4 bg-primary/5 rounded border border-primary/10 flex gap-4">
                    <span class="material-symbols-outlined text-primary">info</span>
                    <p class="text-xs text-primary leading-relaxed font-medium">
                        Values shown are estimates based on your last audited balance. Final figures
                        will be calculated at the point of disbursement based on market valuations.
                    </p>
                </div>
            </div>
            <!-- Support Card -->
            <div class="bg-surface-container p-6 rounded-lg flex items-center gap-6">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-primary shadow-sm">
                    <span class="material-symbols-outlined text-3xl">support_agent</span>
                </div>
                <div>
                    <h4 class="font-black uppercase text-sm tracking-tight text-on-surface">Consult an
                        Advisor</h4>
                    <p class="text-xs text-on-surface-variant mb-2">Unsure about tax implications?</p>
                    <a class="text-xs font-bold text-primary hover:underline uppercase tracking-widest"
                        href="#">Schedule a Call</a>
                </div>
            </div>
        </div>
    </div>
@endsection
