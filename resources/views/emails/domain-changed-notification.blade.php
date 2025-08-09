<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We’ve Moved to a New Address</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(90deg, #2563eb 0%, #06b6d4 100%);
            color: #fff;
            padding: 32px 24px 20px 24px;
            text-align: center;
        }
        .header h1 {
            margin: 0 0 8px 0;
            font-size: 28px;
            font-weight: 700;
        }
        .header p {
            margin: 0;
            font-size: 16px;
            color: #e0f2fe;
        }
        .content {
            padding: 32px 24px 24px 24px;
            color: #1e293b;
        }
        .content h2 {
            font-size: 20px;
            margin: 0 0 16px 0;
            color: #2563eb;
        }
        .content p {
            font-size: 16px;
            margin: 0 0 18px 0;
        }
        .cta {
            display: block;
            width: fit-content;
            margin: 32px auto 0 auto;
            background: linear-gradient(90deg, #2563eb 0%, #06b6d4 100%);
            color: #fff !important;
            text-decoration: none;
            padding: 14px 36px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            box-shadow: 0 4px 16px rgba(37,99,235,0.10);
            transition: background 0.2s;
        }
        .cta:hover {
            background: linear-gradient(90deg, #1d4ed8 0%, #0e7490 100%);
        }
        .footer {
            background: #f1f5f9;
            color: #64748b;
            text-align: center;
            padding: 18px 24px;
            font-size: 13px;
        }
        @media (max-width: 600px) {
            .container { margin: 0; border-radius: 0; }
            .header, .content, .footer { padding-left: 12px; padding-right: 12px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>We’ve Moved!</h1>
            <p>Important update about your account</p>
        </div>
        <div class="content">
            <h2>Hello {{ $user->name }},</h2>
            <p>We’re excited to announce that our website has moved from <b>expenses.duodev.in</b> to our new home at <b>cazhoo.duodev.in</b>.</p>
            <p>All your data, features, and account access remain the same—just at a new, improved address.</p>
            <p style="margin-bottom: 32px;">Please update your bookmarks and use the new link below to access your account:</p>
            <a href="https://cazhoo.duodev.in" class="cta" target="_blank">Visit New Website</a>
            <p style="margin-top: 36px; color: #64748b; font-size: 15px;">If you have any questions or need help, just reply to this email or contact our support team.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }} &mdash; All rights reserved.<br>
            You’re receiving this email because you have an account with us.
        </div>
    </div>
</body>
</html>
