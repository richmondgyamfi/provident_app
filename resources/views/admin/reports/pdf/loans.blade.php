<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Loans Report</title>
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
    <h1>Loans Report</h1>
    <div class="meta">
        From: {{ $from }} | To: {{ $to }}
    </div>

    <table>
        <thead>
        <tr>
            <th>Application Ref</th>
            <th>Staff No</th>
            <th>Member Name</th>
            <th>Loan Type</th>
            <th>Status</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $row)
            <tr>
                <td>{{ $row->application_ref }}</td>
                <td>{{ $row->user?->staff_no }}</td>
                <td>{{ trim(($row->user?->fname ?? '').' '.($row->user?->mname ?? '').' '.($row->user?->lname ?? '')) }}</td>
                <td>{{ $row->loanType?->name }}</td>
                <td>{{ $row->status }}</td>
                <td>{{ number_format((float)$row->amount, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>

