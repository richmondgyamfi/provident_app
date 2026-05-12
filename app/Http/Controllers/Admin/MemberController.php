<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Contribution;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of all members with their contributions.
     */
    public function index()
    {
        // get members, users and contributions table to get staff_no and name
        $members = Member::with(['user', 'contributions' => function ($query) {
            $query->latest()->limit(12);
        }])->join('users', 'members.staff_no', '=', 'users.staff_no')
            ->orderBy('users.fname')
            ->select('members.*')
            ->get();

        return view('admin.members.index', compact('members'));
    }

    /**
     * Display a specific member's profile and contributions.
     */
    public function show(Member $member)
    {
        $member->load(['contributions' => function ($query) {
            $query->orderBy('payroll_year', 'desc')->orderBy('payroll_month', 'desc');
        }]);

        $totalContributions = $member->contributions->sum('contribution_amount');
        $totalEmployee = $member->contributions->sum('employee_amount');
        $totalEmployer = $member->contributions->sum('employer_amount');

        return view('admin.members.show', compact('member', 'totalContributions', 'totalEmployee', 'totalEmployer'));
    }
}
