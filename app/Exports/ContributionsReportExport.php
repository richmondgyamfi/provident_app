<?php

namespace App\Exports;

use App\Models\Contribution;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContributionsReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    public function __construct(private string $fromDate, private string $toDate)
    {
    }

    public function collection()
    {
        // NOTE: Avoid eager-loading uploader relationship here because the
        // underlying users table in this project does not include a `name` column.
        // We only need staff/member fields and contribution fields.
        return Contribution::with(['member'])
            ->whereBetween('created_at', [$this->fromDate, $this->toDate])
            ->orderBy('created_at', 'ASC')
            ->get();
    }

    public function map($contribution): array
    {
        return [
            $contribution->staff_no,
            $contribution->member?->name,
            $contribution->payroll_year,
            $contribution->payroll_month,
            (float) $contribution->contribution_amount,
            (string) $contribution->contribution_type,
            (string) $contribution->status,
            (string) ($contribution->payment_reference ?? ''),
            (string) ($contribution->source ?? ''),
            optional($contribution->created_at)->format('Y-m-d'),
            (string) (
                is_numeric($contribution->uploaded_by ?? null)
                    ? ($contribution->uploaded_by ?? '')
                    : ($contribution->uploaded_by ?? 'Admin')
            ),
        ];
    }

    public function headings(): array
    {
        return [
            'Staff No',
            'Member Name',
            'Payroll Year',
            'Payroll Month',
            'Contribution Amount',
            'Contribution Type',
            'Status',
            'Payment Reference',
            'Source',
            'Created Date',
            'Uploaded By',
        ];
    }

    public function title(): string
    {
        return 'Contributions';
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

