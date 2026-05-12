@extends('layouts.app')

@section('title', 'Members')

@section('content')
    <div class="py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900 dark:text-white">Members</h1>
                <p class="text-slate-500 mt-1">View all provident fund members and their profiles</p>
            </div>
            <div class="text-sm text-slate-500">
                Total Members: <span class="font-bold text-slate-900 dark:text-white">{{ $members->count() }}</span>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                            <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">Staff No</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">Name</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">Bank</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">Account No</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">Monthly Contrib.</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">Contributions</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($members as $member)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $member->staff_no }}</td>
                                <td class="px-6 py-4 text-sm text-slate-900 dark:text-white font-semibold">{{ $member->name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $member->bank_name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $member->account_number }}</td>
                                {{-- <td class="px-6 py-4 text-sm font-semibold text-slate-900 dark:text-white">GHS {{ number_format($member->monthly_contribution ?? 0, 2) }}</td> --}}
                                <td class="px-6 py-4 text-sm font-semibold text-slate-900 dark:text-white"> {{ $member->monthly_contribution }}% of Basic</td>
                                <td class="px-6 py-4">
                                    @php $contribCount = $member->contributions->count(); @endphp
                                    <span class="inline-flex px-2 py-1 rounded text-xs font-bold {{ $contribCount > 0 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400' }}">
                                        {{ $contribCount }} records
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.members.show', $member) }}" class="text-primary hover:underline text-sm font-bold">View Profile</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                    No members found. 
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
