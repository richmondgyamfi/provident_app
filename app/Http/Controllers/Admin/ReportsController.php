<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ContributionsReportExport;
use App\Exports\LoansReportExport;
use App\Exports\WithdrawalsReportExport;
use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Models\Loan;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.reports.index');
    }

    public function data(Request $request)
    {
        $reportType = $request->string('type')->toString();
        $from = $request->input('from');
        $to = $request->input('to');

        $fromDate = $from ? Carbon::parse($from)->startOfDay() : Carbon::now()->subMonths(6)->startOfMonth();
        $toDate = $to ? Carbon::parse($to)->endOfDay() : Carbon::now()->endOfMonth();

        $series = $this->buildMonthlySeries($reportType, $fromDate, $toDate);

        return response()->json([
            'type' => $reportType,
            'from' => $fromDate->toDateString(),
            'to' => $toDate->toDateString(),
            'points' => $series,
            'totals' => [
                'count' => array_sum(array_map(fn ($p) => $p['count'], $series)),
                'amount' => array_sum(array_map(fn ($p) => $p['amount'], $series)),
            ],
        ]);
    }

    public function exportExcel(Request $request)
    {
        $reportType = $request->string('type')->toString();
        $from = $request->input('from');
        $to = $request->input('to');

        $fromDate = $from ? Carbon::parse($from)->startOfDay()->toDateString() : Carbon::now()->subMonths(6)->startOfMonth()->toDateString();
        $toDate = $to ? Carbon::parse($to)->endOfDay()->toDateString() : Carbon::now()->endOfMonth()->toDateString();

        return match ($reportType) {
            'loans' => Excel::download(new LoansReportExport($fromDate, $toDate), 'loan_reports_'.$fromDate.'_to_'.$toDate.'.xlsx'),
            'contributions' => Excel::download(new ContributionsReportExport($fromDate, $toDate), 'contribution_reports_'.$fromDate.'_to_'.$toDate.'.xlsx'),
            'withdrawals' => Excel::download(new WithdrawalsReportExport($fromDate, $toDate), 'withdrawal_reports_'.$fromDate.'_to_'.$toDate.'.xlsx'),
            default => abort(400, 'Invalid report type'),
        };
    }

    public function exportPdf(Request $request)
    {
        // Placeholder minimal implementation.
        // The app may not have a PDF library configured; Excel exports work.
        abort(501, 'PDF export not implemented yet.');
    }

    private function buildMonthlySeries(string $reportType, Carbon $fromDate, Carbon $toDate): array
    {
        $months = [];
        $cursor = $fromDate->copy()->startOfMonth();
        while ($cursor->lte($toDate->copy()->endOfMonth())) {
            $months[] = $cursor->copy();
            $cursor->addMonth();
        }

        $results = [];
        foreach ($months as $month) {
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();

            $label = $month->format('M Y');

            if ($reportType === 'loans') {
                // Use disbursed_at if available; fallback to created_at
                $q = Loan::query();
                $q->whereBetween(DB::raw("COALESCE(disbursed_at, created_at)"), [$start, $end]);

                $count = (clone $q)->count();
                $amount = (clone $q)->sum('amount');
            } elseif ($reportType === 'contributions') {
                $q = Contribution::query();
                $q->whereBetween('created_at', [$start, $end]);

                $count = (clone $q)->count();
                $amount = (clone $q)->sum('contribution_amount');
            } elseif ($reportType === 'withdrawals') {
                $q = Withdrawal::query();
                $q->whereBetween('request_date', [$start, $end]);

                $count = (clone $q)->count();
                $amount = (clone $q)->sum('approved_amount');
            } else {
                $count = 0;
                $amount = 0;
            }

            $results[] = [
                'month' => $label,
                'count' => (int) $count,
                'amount' => (float) $amount,
            ];
        }

        return $results;
    }
}

