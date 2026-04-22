@extends('layouts.app')

@section('title', 'Upload Loan Repayments')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <div class="flex items-start gap-4 mb-8">
        <a href="{{ route('admin.loan-repayment-uploads.index') }}" class="text-slate-500 hover:text-slate-900">
            <span class="material-symbols-outlined mr-1">arrow_back</span> Back to Uploads
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-8">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-6">Upload Loan Repayments</h1>
        <p class="text-slate-600 dark:text-slate-400 mb-8">Use our Excel template to upload monthly loan repayments for multiple members.</p>

        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gradient-to-r from-primary/10 to-blue-100 dark:from-primary/20 dark:to-blue-900/20 border border-primary/20 rounded-xl p-6">
                <h3 class="text-lg font-bold text-primary mb-3">📥 Download Template</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">Standardized Excel template with sample data</p>
<a href="{{ route('admin.loan-repayments.template.download') }}" class="inline-flex items-center bg-primary text-white px-6 py-3 rounded-lg font-bold hover:bg-primary/90 transition-all">
                    <span class="material-symbols-outlined mr-2 text-lg">download</span>
                    Download Template
                </a>
            </div>
            <div class="bg-gradient-to-r from-emerald-100 to-emerald-200 dark:from-emerald-900/20 dark:to-emerald-800/20 border border-emerald-200 dark:border-emerald-800/50 rounded-xl p-6">
                <h3 class="text-lg font-bold text-emerald-800 dark:text-emerald-200 mb-3">📋 Required Columns</h3>
                <div class="space-y-1 text-sm">
                    <div>✓ Staff No (exact match)</div>
                    <div>✓ Month (1-12)</div>
                    <div>✓ Year (2024)</div>
                    <div>✓ Amount (GHS)</div>
                    <div>✓ Payment Method</div>
                    <div>✓ Reference</div>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl mb-6 dark:bg-red-500/10 dark:border-red-500/30 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.loan-repayment-uploads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Excel File (.xlsx, .xls, .csv)</label>
                <input type="file" name="repayment_file" accept=".xlsx,.xls,.csv" required 
                    class="w-full px-4 py-4 border-2 border-dashed border-slate-300 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 file:mr-4 file:py-3 file:px-6 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100 transition-all cursor-pointer" />
                <p class="mt-2 text-xs text-slate-500">Max 10MB. Use the template above for correct formatting.</p>
            </div>

            <div class="flex gap-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                <a href="{{ route('admin.loan-repayment-uploads.index') }}" class="flex-1 py-4 px-8 border border-slate-300 text-slate-700 rounded-xl font-bold text-center hover:bg-slate-50 transition-all">
                    Cancel
                </a>
                <button type="submit" class="flex-1 py-4 px-8 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all shadow-lg flex items-center justify-center">
                    <span class="material-symbols-outlined mr-2">upload</span>
                    Process Upload
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

