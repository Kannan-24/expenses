@php
    use Carbon\Carbon;

    $daysUntilDue = (int) Carbon::now()->diffInDays($schedule->due_date, false);

    if ($daysUntilDue > 0) {
        $statusColor = '#f59e0b'; // amber
        $statusBg = '#fef3c7';
        $statusText = "Due in {$daysUntilDue} day" . ($daysUntilDue > 1 ? 's' : '');
        $urgencyEmoji = '⏰';
        $headerBg = 'linear-gradient(90deg, #d97706 0%, #f59e0b 100%)';
    } elseif ($daysUntilDue == 0) {
        $statusColor = '#dc2626'; // red
        $statusBg = '#fee2e2';
        $statusText = 'Due Today';
        $urgencyEmoji = '🚨';
        $headerBg = 'linear-gradient(90deg, #dc2626 0%, #ef4444 100%)';
    } else {
        $statusColor = '#dc2626'; // red
        $statusBg = '#fee2e2';
        $statusText = 'Overdue by ' . abs($daysUntilDue) . ' day' . (abs($daysUntilDue) > 1 ? 's' : '');
        $urgencyEmoji = '❗';
        $headerBg = 'linear-gradient(90deg, #991b1b 0%, #dc2626 100%)';
    }
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMI Payment {{ $statusText }} - {{ $schedule->emiLoan->name }}</title>
</head>

<body
    style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); margin: 0; padding: 0;">
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" style="padding: 20px;">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.08); overflow: hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background: {{ $headerBg }}; padding: 30px; text-align: center;">
                            <div style="font-size: 48px; margin-bottom: 10px;">{{ $urgencyEmoji }}</div>
                            <h1 style="color: #ffffff; margin: 0; font-size: 26px; font-weight: 600;">EMI Payment
                                {{ $statusText }}</h1>
                            <p style="color: rgba(255,255,255,0.9); margin: 8px 0 0 0; font-size: 16px;">Hi
                                {{ $user->name }}, your payment requires attention</p>
                        </td>
                    </tr>

                    <!-- Status Badge -->
                    <tr>
                        <td style="padding: 0; text-align: center;">
                            <div
                                style="background-color: {{ $statusBg }}; color: {{ $statusColor }}; padding: 12px 20px; margin: 0; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                                {{ $statusText }}
                            </div>
                        </td>
                    </tr>

                    <!-- EMI Details -->
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="color: #1f2937; margin: 0 0 20px 0; font-size: 20px; text-align: center;">
                                {{ $schedule->emiLoan->name }}</h2>

                            <table width="100%" cellspacing="0" cellpadding="0"
                                style="background-color: #f9fafb; border-radius: 12px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td
                                                    style="padding: 8px 0; color: #6b7280; font-size: 14px; font-weight: 500;">
                                                    EMI Amount:</td>
                                                <td
                                                    style="padding: 8px 0; color: #1f2937; font-size: 18px; font-weight: 700; text-align: right;">
                                                    ₹{{ number_format($schedule->total_amount, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding: 8px 0; color: #6b7280; font-size: 14px; font-weight: 500;">
                                                    Due Date:</td>
                                                <td
                                                    style="padding: 8px 0; color: #1f2937; font-size: 16px; font-weight: 600; text-align: right;">
                                                    {{ $schedule->due_date->format('M d, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding: 8px 0; color: #6b7280; font-size: 14px; font-weight: 500;">
                                                    Principal:</td>
                                                <td
                                                    style="padding: 8px 0; color: #1f2937; font-size: 14px; text-align: right;">
                                                    ₹{{ number_format($schedule->principal_amount, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding: 8px 0; color: #6b7280; font-size: 14px; font-weight: 500;">
                                                    Interest:</td>
                                                <td
                                                    style="padding: 8px 0; color: #1f2937; font-size: 14px; text-align: right;">
                                                    ₹{{ number_format($schedule->interest_amount, 2) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            @if ($daysUntilDue <= 0)
                                <div
                                    style="background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 16px; margin: 20px 0; border-radius: 6px;">
                                    <p style="color: #dc2626; margin: 0; font-size: 14px; font-weight: 500;">
                                        ⚠️ This payment is {{ $daysUntilDue == 0 ? 'due today' : 'overdue' }}. Please
                                        make the payment as soon as possible to avoid late fees or penalties.
                                    </p>
                                </div>
                            @else
                                <div
                                    style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 16px; margin: 20px 0; border-radius: 6px;">
                                    <p style="color: #d97706; margin: 0; font-size: 14px; font-weight: 500;">
                                        💡 Friendly reminder: Your EMI payment is due in {{ $daysUntilDue }}
                                        day{{ $daysUntilDue > 1 ? 's' : '' }}. Plan ahead to ensure timely payment.
                                    </p>
                                </div>
                            @endif
                        </td>
                    </tr>

                    <!-- Action Button -->
                    <tr>
                        <td style="padding: 0 30px 30px 30px; text-align: center;">
                            <a href="{{ url('/emi-loans/' . $schedule->emi_loan_id) }}"
                                style="display: inline-block; background: linear-gradient(90deg, #3b82f6 0%, #1d4ed8 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-size: 16px; font-weight: 600; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);">
                                View EMI Details & Pay Now
                            </a>
                        </td>
                    </tr>

                    <!-- Additional Info -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px 30px; border-top: 1px solid #e5e7eb;">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" style="vertical-align: top;">
                                        <h4
                                            style="color: #374151; margin: 0 0 8px 0; font-size: 14px; font-weight: 600;">
                                            You can update your emi details to keep track of transactions
                                        </h4>
                                        <p style="color: #6b7280; margin: 0; font-size: 13px; line-height: 1.5;">
                                            • Online Banking<br>
                                            • UPI Payment<br>
                                            • Bank Transfer<br>
                                            • Cash Deposit
                                        </p>
                                    </td>
                                    <td width="50%" style="vertical-align: top; text-align: right;">
                                        <h4
                                            style="color: #374151; margin: 0 0 8px 0; font-size: 14px; font-weight: 600;">Need Help?</h4>
                                        <p style="color: #6b7280; margin: 0; font-size: 13px; line-height: 1.5;">
                                            Contact Support<br>
                                            <a href="mailto:contact@{{ config('app.support_email') }}"
                                                style="color: #60a5fa; text-decoration: none;">{{ config('app.support_email') }}</a><br>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #1f2937; padding: 25px 30px; text-align: center;">
                            <p style="color: #9ca3af; margin: 0 0 12px 0; font-size: 14px;">
                                This is an automated reminder for your EMI payment.
                                <a href="{{ url('/emi-loans') }}" style="color: #60a5fa; text-decoration: none;">Manage
                                    all EMIs</a>
                            </p>
                            <p style="color: #6b7280; margin: 0; font-size: 12px;">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. Stay on top of your financial
                                commitments.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
