<?php

namespace App\Exports;

use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WithdrawalsReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    public function __construct(private string $fromDate, private string $toDate)
    {
    }

    public function collection()
    {
        return Withdrawal::with(['member'])
            ->whereBetween('request_date', [$this->fromDate, $this->toDate])
            ->orderBy('request_date', 'ASC')
            ->get();
    }

    public function map($withdrawal): array
    {
        return [
            $withdrawal->member?->staff_no,
            $withdrawal->member?->name,
            (float) $withdrawal->amount,
            (string) ($withdrawal->reason ?? ''),
            (string) ($withdrawal->status ?? ''),
            (float) ($withdrawal->approved_amount ?? 0),
            optional($withdrawal->request_date)->format('Y-m-d'),
            optional($withdrawal->processed_at)->format('Y-m-d H:i:s'),
            (string) ($withdrawal->payment_reference ?? ''),
        ];
    }

    public function headings(): array
    {
        return [
            'Staff No',
            'Member Name',
            'Requested Amount',
            'Reason',
            'Status',
            'Approved Amount',
            'Request Date',
            'Processed At',
            'Payment Reference',
        ];
    }

    public function title(): string
    {
        return 'Withdrawals';
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

