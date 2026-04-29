<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Loan;
use App\Models\LoanRepayment;
use App\Models\Member;
use App\Models\OpeningBalance;
use App\Models\Withdrawal;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'members_count' => Member::count(),
            'total_contributions' => Contribution::sum('contribution_amount'),
            'loans_issued' => Loan::where('status', 'approved')->sum('amount'),
            'total_repayments' => LoanRepayment::sum('amount'),
            'total_withdrawals' => Withdrawal::whereIn('status', ['approved', 'paid'])->sum('amount'),
            'fund_balance' => OpeningBalance::sum('amount'),
            // Additional statistics
            'pending_loans' => Loan::where('status', 'pending')->count(),
            'active_loans' => Loan::where('status', 'approved')->where('outstanding_balance', '>', 0)->count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            'recent_contributions_count' => Contribution::where('created_at', '>=', now()->subDays(30))->count(),
            'recent_repayments_count' => LoanRepayment::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        // Get recent activities (last 10 activities across the system)
        $activities = collect();

        // Recent contributions
        $recentContributions = Contribution::with('member')
            ->latest()
            ->take(5)
            ->get();

        foreach ($recentContributions as $contribution) {
            $activities->push([
                'type' => 'contribution',
                'title' => 'New Contribution',
                'description' => '₵'.number_format($contribution->contribution_amount, 2).' from '.($contribution->member->fname ?? 'Unknown').' '.($contribution->member->lname ?? ''),
                'date' => $contribution->created_at,
                'icon' => 'payments',
                'color' => 'emerald',
                'member' => $contribution->member,
                'amount' => $contribution->contribution_amount,
            ]);
        }

        // Recent loan applications
        $recentLoans = Loan::with('user')
            ->latest()
            ->take(3)
            ->get();

        foreach ($recentLoans as $loan) {
            $activities->push([
                'type' => 'loan',
                'title' => 'Loan '.ucfirst($loan->status),
                'description' => '₵'.number_format($loan->amount, 2).' application by '.($loan->user->fname ?? 'Unknown').' '.($loan->user->lname ?? ''),
                'date' => $loan->created_at,
                'icon' => 'receipt_long',
                'color' => $loan->status === 'approved' ? 'blue' : ($loan->status === 'pending' ? 'yellow' : 'red'),
                'member' => $loan->user,
                'amount' => $loan->amount,
            ]);
        }

        // Recent loan repayments
        $recentRepayments = LoanRepayment::with('loan.user')
            ->latest()
            ->take(3)
            ->get();

        foreach ($recentRepayments as $repayment) {
            $activities->push([
                'type' => 'repayment',
                'title' => 'Loan Repayment',
                'description' => '₵'.number_format($repayment->amount, 2).' received from '.($repayment->loan->user->fname ?? 'Unknown').' '.($repayment->loan->user->lname ?? ''),
                'date' => $repayment->created_at,
                'icon' => 'account_balance',
                'color' => 'blue',
                'member' => $repayment->loan->user,
                'amount' => $repayment->amount,
            ]);
        }

        // Recent withdrawals
        $recentWithdrawals = Withdrawal::with('member')
            ->latest()
            ->take(2)
            ->get();

        foreach ($recentWithdrawals as $withdrawal) {
            $activities->push([
                'type' => 'withdrawal',
                'title' => 'Withdrawal '.ucfirst($withdrawal->status),
                'description' => '₵'.number_format($withdrawal->amount, 2).' withdrawal request by '.($withdrawal->member->fname ?? 'Unknown').' '.($withdrawal->member->lname ?? ''),
                'date' => $withdrawal->created_at,
                'icon' => 'wallet',
                'color' => $withdrawal->status === 'approved' ? 'green' : ($withdrawal->status === 'pending' ? 'yellow' : 'red'),
                'member' => $withdrawal->member,
                'amount' => $withdrawal->amount,
            ]);
        }

        // Sort activities by date and take top 10
        $recentActivities = $activities->sortByDesc('date')->take(10);

        // Get recent transactions for the table (last 10 transactions)
        $recentTransactions = collect();

        // Add recent contributions to transactions
        foreach ($recentContributions->take(3) as $contribution) {
            $recentTransactions->push([
                'transaction_id' => 'CON-'.$contribution->id,
                'member_name' => ($contribution->member->fname ?? 'Unknown').' '.($contribution->member->lname ?? ''),
                'member_id' => $contribution->member->member_id ?? 'N/A',
                'type' => 'Contribution',
                'type_icon' => 'payments',
                'type_color' => 'primary',
                'amount' => $contribution->contribution_amount * 100, // Convert to cents for consistency
                'date' => $contribution->created_at,
                'status' => 'Completed',
                'status_color' => 'emerald',
            ]);
        }

        // Add recent repayments to transactions
        foreach ($recentRepayments->take(3) as $repayment) {
            $recentTransactions->push([
                'transaction_id' => 'REP-'.$repayment->id,
                'member_name' => ($repayment->loan->user->fname ?? 'Unknown').' '.($repayment->loan->user->lname ?? ''),
                'member_id' => $repayment->loan->user->member_id ?? 'N/A',
                'type' => 'Loan Repayment',
                'type_icon' => 'account_balance',
                'type_color' => 'primary',
                'amount' => $repayment->amount * 100, // Convert to cents for consistency
                'date' => $repayment->created_at,
                'status' => 'Completed',
                'status_color' => 'emerald',
            ]);
        }

        // Add recent withdrawals to transactions
        foreach ($recentWithdrawals->take(2) as $withdrawal) {
            $statusColor = $withdrawal->status === 'approved' ? 'emerald' : ($withdrawal->status === 'pending' ? 'amber' : 'red');
            $recentTransactions->push([
                'transaction_id' => 'WD-'.$withdrawal->id,
                'member_name' => ($withdrawal->member->fname ?? 'Unknown').' '.($withdrawal->member->lname ?? ''),
                'member_id' => $withdrawal->member->member_id ?? 'N/A',
                'type' => 'Withdrawal',
                'type_icon' => 'wallet',
                'type_color' => 'accent-red',
                'amount' => $withdrawal->amount * 100, // Convert to cents for consistency
                'date' => $withdrawal->created_at,
                'status' => ucfirst($withdrawal->status),
                'status_color' => $statusColor,
            ]);
        }

        // Sort transactions by date and take top 8
        $recentTransactions = $recentTransactions->sortByDesc('date')->take(8);

        // Get contribution trends for the last 6 months
        $contributionTrends = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();

            $monthlyContributions = Contribution::whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('contribution_amount');

            $contributionTrends->push([
                'month' => $date->format('M'),
                'year' => $date->format('Y'),
                'amount' => $monthlyContributions,
                'count' => Contribution::whereBetween('created_at', [$monthStart, $monthEnd])->count(),
            ]);
        }

        return view('admin.admin-dashboard', compact('stats', 'recentActivities', 'recentTransactions', 'contributionTrends'));
    }
}
