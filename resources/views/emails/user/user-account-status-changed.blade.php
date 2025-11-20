<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Status Updated</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .container {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 30px;
            border: 1px solid #e0e0e0;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            margin: -30px -30px 20px -30px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            margin: 5px 0;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-suspended {
            background-color: #fff3cd;
            color: #856404;
        }

        .reason-box {
            background-color: #fff;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">Account Status Update</h1>
        </div>

        <p>Hello {{ $user->first_name }} {{ $user->last_name }},</p>

        <p>Your account status has been updated by our administration team.</p>

        <div style="margin: 20px 0;">
            <strong>Previous Status:</strong>
            <span class="status-badge status-{{ strtolower($oldStatus) }}">
                {{ ucfirst($oldStatus) }}
            </span>
        </div>

        <div style="margin: 20px 0;">
            <strong>New Status:</strong>
            <span class="status-badge status-{{ strtolower($newStatus) }}">
                {{ ucfirst($newStatus) }}
            </span>
        </div>

        @if ($reason)
            <div class="reason-box">
                <h3 style="margin-top: 0; color: #667eea;">Reason for Status Change:</h3>
                <p style="margin-bottom: 0;">{{ $reason }}</p>
            </div>
        @endif

        @if ($changedBy)
            <p style="margin-top: 20px;">
                <small>Changed by: {{ $changedBy->first_name }} {{ $changedBy->last_name }}</small>
            </p>
        @endif

        <p style="margin-top: 30px;">
            If you have any questions or concerns about this change, please contact our support team.
        </p>

        <div style="margin: 20px; text-align: center !important;">
            <a href="mailto:luisacuna@gmail.com" class="status-badge"
                style="display: inline-block; color: white; text-decoration: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                Contact Us
            </a>
        </div>


        <div class="footer">
            <p>This is an automated email. Please do not reply to this message.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
