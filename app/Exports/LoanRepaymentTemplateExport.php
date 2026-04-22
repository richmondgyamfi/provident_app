<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LoanRepaymentTemplateExport implements FromArray, WithHeadings, WithStyles, WithTitle
{
    public function array(): array
    {
        return [
            // Sample rows
            ['STAFF001', 10, 2024, 500.00, 'salary_deduction', 'REP-202410001'],
            ['STAFF002', 10, 2024, 750.00, 'bank_transfer', 'REP-202410002'],
        ];
    }

    public function headings(): array
    {
        return [
            'staff_no (required, matches Member.staff_no with active loan)',
            'payroll_month (1-12)',
            'payroll_year (e.g. 2024)',
            'amount (GHS)',
            'payment_method (salary_deduction, bank_transfer, cash, cheque)',
            'reference (e.g. REP-YYYYMMDD-###)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header row styling
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']]],
        ];
    }

    public function title(): string
    {
        return 'Loan_Repayments_Template';
    }
}
