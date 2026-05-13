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
            'fund_balance' => OpeningBalance::sum('amount'), // or calculate
        ];

        return view('admin.admin-dashboard', compact('stats'));
    }
}
