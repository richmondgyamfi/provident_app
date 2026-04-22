
<!DOCTYPE html>
<html>
<head>
    <title>Loan Application Received</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #374151;">
    <div style="max-width: 600px; margin: 0 auto; padding: 40px 20px;">
        <div style="text-align: center; margin-bottom: 40px;">
            <img src="{{ asset('public/ucclogo_horizontal_blue.png') }}" alt="UCC Provident Fund" style="height: 50px;">
        </div>

        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 32px; box-shadow: 0 4px 6px -1px rgba(0, 0,0,0.1);">
            <h1 style="color: #1f2937; font-size: 24px; font-weight: 700; margin-bottom: 8px;">Loan Application Received</h1>
            <p style="color: #6b7280; font-size: 16px; margin-bottom: 24px;">Reference: <strong>{{ $loan->application_ref }}</strong></p>

            <div style="background: #f9fafb; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
                <h3 style="color: #1f2937; font-size: 18px; font-weight: 600; margin-bottom: 12px;">Your Application Details</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; font-weight: 500; color: #374151;">Loan Type:</td>
                        <td style="padding: 8px 0; color: #374151;">{{ $loan->loanType->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: 500; color: #374151;">Amount Requested:</td>
                        <td style="padding: 8px 0; color: #374151;">₵{{ number_format($loan->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: 500; color: #374151;">Repayment Period:</td>
                        <td style="padding: 8px 0; color: #374151;">{{ $loan->term_months }} months</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: 500; color: #374151;">Monthly Payment:</td>
                        <td style="padding: 8px 0; color: #374151;">₵{{ number_format($loan->monthly_payment, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: 500; color: #374151;">Interest Rate:</td>
                        <td style="padding: 8px 0; color: #374151;">{{ $loan->interest_rate }}% p.a.</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: 500; color: #374151;">Total Repayable:</td>
                        <td style="padding: 8px 0; color: #374151;">₵{{ number_format($loan->total_repayable, 2) }}</td>
                    </tr>
                </table>
            </div>

            <div style="margin-bottom: 24px;">
                <h3 style="color: #1f2937; font-size: 18px; font-weight: 600; margin-bottom: 12px;">Next Steps</h3>
                <ul style="color: #6b7280; margin: 0; padding-left: 20px;">
                    <li>Our team will review your application within <strong>3-5 business days</strong>.</li>
                    <li>You will be notified via email about the decision.</li>
                    <li>Upon approval, funds will be disbursed to your registered bank account.</li>
                </ul>
            </div>

            <div style="text-align: center; margin-top: 32px;">
                <p style="color: #6b7280; font-size: 14px;">
                    Thank you for choosing UCC Provident Fund.
                </p>
                <p style="color: #6b7280; font-size: 14px; margin-top: 8px;">
                    <strong>UCC Provident Fund Management</strong>
                </p>
            </div>
        </div>
    </div>
</body>
</html>

