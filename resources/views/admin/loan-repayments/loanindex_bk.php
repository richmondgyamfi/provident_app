@extends('layouts.app')

@section('title', 'Loan Repayment Uploads')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Loan Repayment Uploads</h1>
        <a href="{{ route('admin.loan-repayment-uploads.create') }}" class="bg-primary text-white px-6 py-2 rounded-lg font-bold hover:bg-primary/90">
            <span class="material-symbols-outlined mr-2">upload_file</span>
            Upload Repayments
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-900 dark:text-slate-100 uppercase tracking-wider">File</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-900 dark:text-slate-100 uppercase tracking-wider">Records</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-900 dark:text-slate-100 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-900 dark:text-slate-100 uppercase tracking-wider">Uploaded By</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-900 dark:text-slate-100 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-900 dark:text-slate-100 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse ($uploads as $upload)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="font-mono text-sm text-slate-900 dark:text-slate-100">{{ $upload->filename }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-lg text-primary">{{ $upload->repayments_count }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-{{ $statusClass ?? 'gray' }}-100 text-{{ $statusClass ?? 'gray' }}-800 dark:bg-{{ $statusClass ?? 'gray' }}-900 dark:text-{{ $statusClass ?? 'gray' }}-200">
                                {{ ucfirst($upload->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">{{ $upload->user->name ?? 'System' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">{{ $upload->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.loan-repayment-uploads.show', $upload) }}" class="text-primary hover:text-primary/80 font-bold text-sm">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            <span class="material-symbols-outlined text-4xl block mb-2 opacity-50">upload</span>
                            No repayment uploads yet. <a href="{{ route('admin.loan-repayment-uploads.create') }}" class="text-primary font-bold">Upload now</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700">
            {{ $uploads->links() }}
        </div>
    </div>
</div>
@endsection

