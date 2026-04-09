@extends('layouts.app')

@section('title', 'Withdrawal Requests')

@section('content')
<div class="p-4 sm:p-8">
    <div class="flex justify-between items-end gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black">Withdrawal Requests</h1>
            <p class="text-slate-500 mt-1">Review and approve member withdrawal applications</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-800">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Member</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Amount</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Reason</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Requested</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($withdrawals as $withdrawal)
                    <tr>
                        <td class="px-6 py-4">
                            {{ $withdrawal->member->name }} ({{ $withdrawal->member->staff_no }})
                        </td>
                        <td class="px-6 py-4 font-bold">$ {{ number_format($withdrawal->amount, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-slate-100 text-slate-800 rounded-full text-xs font-bold">
                                {{ ucfirst(str_replace('_', ' ', $withdrawal->reason)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $withdrawal->request_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            @php $color = $withdrawal->status_color; @endphp
                            <span class="px-2 py-1 bg-{{ $color }}-100 text-{{ $color }}-800 rounded-full text-xs font-bold">
                                {{ ucfirst($withdrawal->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.withdrawals.show', $withdrawal) }}" class="text-primary hover:underline text-sm font-bold">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            No withdrawal requests
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $withdrawals->links() }}
    </div>
</div>
@endsection
