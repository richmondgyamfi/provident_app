<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Withdrawals Report</title>
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
    <h1>Withdrawals Report</h1>
    <div class="meta">
        From: {{ $from }} | To: {{ $to }}
    </div>

    <table>
        <thead>
        <tr>
            <th>Staff No</th>
            <th>Member Name</th>
            <th>Requested</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Approved</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $row)
            <tr>
                <td>{{ $row->member?->staff_no }}</td>
                <td>{{ $row->member?->name }}</td>
                <td>{{ number_format((float)$row->amount, 2) }}</td>
                <td>{{ $row->reason }}</td>
                <td>{{ $row->status }}</td>
                <td>{{ number_format((float)($row->approved_amount ?? 0), 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>

