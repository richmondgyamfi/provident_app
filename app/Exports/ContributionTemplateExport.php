<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContributionTemplateExport implements FromArray, WithHeadings, WithStyles, WithTitle
{
    public function array(): array
    {
        return [
            // Sample rows
            ['STAFF001', 10, 2024, 'mich', 100.00, 'Mandatory'],
            ['STAFF002', 10, 2024, 'rich', 150.00, 'Voluntary'],
        ];
    }

    public function headings(): array
    {
        return [
            'staff_no (required, matches Member.staff_no)',
            'payroll_month (1-12)',
            'payroll_year (e.g. 2024)',
            'name',
            'contribution_amount',
            // 'basic_salary (GHS)',
            'contribution_type (Mandatory, Voluntary, Arrears, Adjustment)',
            // 'payment_reference (e.g. TXN-YYYYMMDD-###)',
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
        return 'Staff_Contributions_Template';
    }
}
