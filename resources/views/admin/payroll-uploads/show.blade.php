@extends('layouts.app')

@section('title', 'Payroll Upload Details')

@section('content')
<div class="p-4 sm:p-8 space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white">Upload {{ $upload->payroll_upload_id }}</h1>
            <p class="text-slate-500 mt-1">Uploaded {{ $upload->created_at->format('M d, Y H:i') }}</p>
        </div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-{{ $statusClass }}-100 text-{{ $statusClass }}-800 capitalize">
            {{ ucfirst($upload->status) }}
        </span>
    </div>

    <!-- Summary Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border shadow-sm">
            <p class="text-slate-500 text-sm uppercase font-bold">File</p>
            <p class="font-black text-slate-900 dark:text-white mt-1">{{ $upload->filename }}</p>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border shadow-sm">
            <p class="text-slate-500 text-sm uppercase font-bold">Records Processed</p>
            <p class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ $upload->records_count }}</p>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border shadow-sm">
            <p class="text-slate-500 text-sm uppercase font-bold">Uploaded By</p>
            <p class="text-lg font-bold text-slate-900 dark:text-white mt-1">{{ $upload->user->name ?? 'System' }}</p>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border shadow-sm">
            <p class="text-slate-500 text-sm uppercase font-bold">Date</p>
            <p class="text-lg font-bold text-slate-900 dark:text-white mt-1">{{ $upload->created_at->format('M d, Y') }}</p>
        </div>
    </div>

    @if($upload->notes)
    <div class="bg-amber-50 dark:bg-amber-900/10 p-6 rounded-xl border border-amber-200">
        <h3 class="font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined text-amber-500">info</span> Processing Notes / Issues
        </h3>
        <ul class="space-y-1 text-sm text-amber-800 dark:text-amber-200 list-disc pl-5">
            @foreach(explode('; ', $upload->notes) as $note)
                <li>{{ trim($note) }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Success Records Table -->
    <div class="space-y-3">
        <h3 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <span class="material-symbols-outlined text-green-500">check_circle</span>
            Successfully Imported Records ({{ $contributions->count() }})
        </h3>
        @if($contributions->count() > 0)
            <div class="bg-white dark:bg-slate-900 rounded-xl border shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-800">
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Member</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Period</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Amounts</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($contributions as $contrib)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="size-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs font-bold">
                                                {{ substr($contrib->member->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-slate-900 dark:text-white">{{ $contrib->member->name }}</p>
                                                <p class="text-xs text-slate-500">{{ $contrib->staff_no }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ date('M Y', mktime(0, 0, 0, $contrib->payroll_month, 1, $contrib->payroll_year)) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            {{-- <p class="text-sm">Employee: ₵{{ number_format($contrib->employee_amount, 2) }}</p> --}}
                                            <p class="font-bold">{{ number_format($contrib->contribution_amount, 2) }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ ucfirst($contrib->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <p class="text-slate-500 text-center py-12">No successful imports from this file.</p>
        @endif
    </div>

    <div class="flex gap-3 pt-6">
        <a href="{{ route('payroll-uploads.index') }}" class="flex-1 py-3 px-6 border border-slate-300 text-slate-700 rounded-lg font-bold text-center hover:bg-slate-50 transition-colors">
            ← Back to Uploads
        </a>
        <a href="{{ route('payroll.template.download') }}" class="flex-1 py-3 px-6 bg-primary text-white rounded-lg font-bold text-center hover:bg-primary/90 transition-colors">
            Download New Template
        </a>
    </div>
</div>
@endsection

