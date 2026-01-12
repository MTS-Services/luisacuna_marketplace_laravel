<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 6px;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #222;
        }
        .description {
            font-size: 15px;
            margin-bottom: 25px;
        }
        .action-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Hello {{ $userName ?? 'User' }},</p>

        <div class="title">
            Dispute Resolution Update
        </div>

        <div class="description">
                We wanted to let you know that there has been an update regarding your dispute.

                <br><br>
                <strong>Order ID:</strong> {{ $orderId ?? 'N/A' }}<br>
                <strong>Price:</strong> ${{ $price ?? '0.00' }}<br>
                <strong>Dispute Reason:</strong> {{ $disputeReason ?? 'N/A' }}

                <br><br>
                Our support team has reviewed the information provided by all parties and has
                taken the necessary steps to move the resolution process forward.

                <br><br>
                Please click the button below to view the full details of your dispute and any
                actions that may be required from your side.
            </div>


        <p style="text-align: center;">
            <a href="{{ $disputeUrl ?? '#' }}" class="action-button">
                View Dispute
            </a>
        </p>

        <div class="footer">
            <p>
                If you believe this update was sent to you by mistake, you may safely ignore
                this email.
            </p>
            <p>
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
