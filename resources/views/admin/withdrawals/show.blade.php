@extends('layouts.app')

@section('title', 'Withdrawal Request')

@section('content')
<div class="p-4 sm:p-8 space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Withdrawal Request #{{ $withdrawal->id }}</h1>
        <a href="{{ route('admin.withdrawals.index') }}" class="px-4 py-2 border border-slate-200 rounded-lg text-sm font-bold">← Back</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Request Details -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 p-6">
            <h3 class="text-lg font-bold mb-6">Request Details</h3>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Member</span>
                    <span class="font-bold">{{ $withdrawal->member->name }} ({{ $withdrawal->member->staff_no }})</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Amount</span>
                    <span class="font-bold text-2xl">$ {{ number_format($withdrawal->amount, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Reason</span>
                    <span>{{ ucfirst(str_replace('_', ' ', $withdrawal->reason)) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Requested</span>
                    <span>{{ $withdrawal->request_date->format('M d, Y') }}</span>
                </div>
                @if($withdrawal->notes)
                <div>
                    <span class="text-slate-500 block mb-1">Notes</span>
                    <p>{{ $withdrawal->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Status & Actions -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 p-6">
            <h3 class="text-lg font-bold mb-6">Approval</h3>
            
            @php $statusClass = $withdrawal->status_color; @endphp
            <div class="mb-6 p-4 bg-{{ $statusClass }}-50 border border-{{ $statusClass }}-200 rounded-lg">
                <span class="inline-flex px-3 py-1 bg-{{ $statusClass }}-100 text-{{ $statusClass }}-800 font-bold rounded-full text-sm">
                    {{ ucfirst($withdrawal->status) }}
                </span>
            </div>

            <form action="{{ route('admin.withdrawals.update-status', $withdrawal) }}" method="POST">
                @csrf @method('PATCH')
                <div class="space-y-4 mb-6">
                    <label class="block font-bold text-sm text-slate-700 mb-2">Status</label>
                    <select name="status" class="w-full p-3 border border-slate-300 rounded-lg">
                        <option value="pending" {{ $withdrawal->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved">Approve</option>
                        <option value="rejected">Reject</option>
                        <option value="paid">Mark Paid</option>
                    </select>
                    
                    @if($withdrawal->status != 'paid')
                    <div>
                        <label class="block font-bold text-sm text-slate-700 mb-2">Approved Amount</label>
                        <input type="number" step="0.01" name="approved_amount" value="{{ $withdrawal->amount }}" 
                            class="w-full p-3 border border-slate-300 rounded-lg" />
                    </div>
                    @endif
                    
                    <div>
                        <label class="block font-bold text-sm text-slate-700 mb-2">Feedback Notes</label>
                        <textarea name="notes" rows="3" class="w-full p-3 border border-slate-300 rounded-lg">{{ old('notes', $withdrawal->notes) }}</textarea>
                    </div>
                </div>
                <button type="submit" class="w-full py-3 bg-primary text-white font-bold rounded-lg hover:bg-primary/90">
                    Update Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
