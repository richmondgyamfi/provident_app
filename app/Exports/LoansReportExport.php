<?php

namespace App\Exports;

use App\Models\Loan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LoansReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    public function __construct(private string $fromDate, private string $toDate)
    {
    }

    public function collection()
    {
        return Loan::with(['user', 'loanType'])
            ->whereBetween(
                DB::raw('COALESCE(disbursed_at, created_at)'),
                [$this->fromDate, $this->toDate]
            )
            ->orderByRaw('COALESCE(disbursed_at, created_at) ASC')
            ->get();
    }

    public function map($loan): array
    {
        $memberName = trim(
            ($loan->user?->fname ?? '') . ' ' .
            ($loan->user?->mname ?? '') . ' ' .
            ($loan->user?->lname ?? '')
        );

        return [
            $loan->application_ref,
            $loan->user?->staff_no,
            $memberName ?: 'N/A',
            $loan->loanType?->name,
            (string) $loan->status,
            (float) $loan->amount,
            (float) $loan->interest_rate,
            (int) $loan->term_months,
            (float) $loan->monthly_payment,
            (float) $loan->outstanding_balance,
            optional($loan->disbursed_at ?: $loan->created_at)->format('Y-m-d'),
            (string) ($loan->purpose ?? ''),
        ];
    }

    public function headings(): array
    {
        return [
            'Application Ref',
            'Staff No',
            'Member Name',
            'Loan Type',
            'Status',
            'Amount',
            'Interest Rate',
            'Term (Months)',
            'Monthly Payment',
            'Outstanding Balance',
            'Date (Disbursed/Applied)',
            'Purpose',
        ];
    }

    public function title(): string
    {
        return 'Loans';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '4472C4'],
                ],
            ],
        ];
    }
}

