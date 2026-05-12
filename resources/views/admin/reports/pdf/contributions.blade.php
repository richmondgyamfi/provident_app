<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contributions Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; font-size: 12px; }
        th { background: #f3f4f6; text-align: left; }
        h1 { margin: 0 0 10px; }
        .meta { margin-bottom: 15px; font-size: 12px; color: #555; }
    </style>
</head>
<body>
    <h1>Contributions Report</h1>
    <div class="meta">
        From: {{ $from }} | To: {{ $to }}
    </div>

    <table>
        <thead>
        <tr>
            <th>Staff No</th>
            <th>Member Name</th>
            <th>Year</th>
            <th>Month</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $row)
            <tr>
                <td>{{ $row->staff_no }}</td>
                <td>{{ $row->member?->name }}</td>
                <td>{{ $row->payroll_year }}</td>
                <td>{{ $row->payroll_month }}</td>
                <td>{{ number_format((float)$row->contribution_amount, 2) }}</td>
                <td>{{ $row->contribution_type }}</td>
                <td>{{ $row->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>

