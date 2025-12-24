<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Received</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #1b1b1b;
            background: linear-gradient(135deg, #0d061a 0%, #1b0c33 50%, #351966 100%);
            padding: 40px 20px;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(133, 62, 255, 0.3);
        }

        .header {
            background: linear-gradient(135deg, #12d212 0%, #059669 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .icon {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 16px;
        }

        .header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            color: #1b1b1b;
            margin-bottom: 16px;
        }

        .message {
            color: #4b5563;
            margin-bottom: 24px;
            font-size: 15px;
        }

        .amount-card {
            background: linear-gradient(135deg, rgba(18, 210, 18, 0.08) 0%, rgba(5, 150, 105, 0.08) 100%);
            border: 2px solid #12d212;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin: 24px 0;
        }

        .amount-label {
            font-size: 14px;
            color: #059669;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .amount {
            font-size: 42px;
            font-weight: 800;
            background: linear-gradient(135deg, #12d212 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .details-card {
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
            margin: 24px 0;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #6b7280;
            font-weight: 500;
            font-size: 14px;
        }

        .detail-value {
            color: #1b1b1b;
            font-weight: 600;
            font-size: 14px;
        }

        .info-box {
            background: rgba(133, 62, 255, 0.08);
            border-left: 4px solid #853eff;
            border-radius: 8px;
            padding: 16px 20px;
            margin: 24px 0;
        }

        .info-title {
            font-weight: 700;
            color: #1b1b1b;
            margin-bottom: 12px;
            font-size: 15px;
        }

        .info-list {
            list-style: none;
            padding: 0;
        }

        .info-list li {
            color: #4b5563;
            padding: 6px 0;
            padding-left: 24px;
            position: relative;
            font-size: 14px;
        }

        .info-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #12d212;
            font-weight: bold;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #12d212 0%, #059669 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 24px auto;
            text-align: center;
            box-shadow: 0 4px 12px rgba(18, 210, 18, 0.4);
            transition: transform 0.2s;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(18, 210, 18, 0.5);
        }

        .button-wrapper {
            text-align: center;
        }

        .footer {
            background: #0d061a;
            padding: 30px;
            text-align: center;
        }

        .footer-text {
            color: #a78bfa;
            font-size: 13px;
            margin: 8px 0;
        }

        .footer-brand {
            color: #853eff;
            font-weight: 600;
            margin-top: 16px;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="header">
            <div class="header-content">
                <div class="icon">💰</div>
                <h1>Payment Received!</h1>
            </div>
        </div>

        <div class="content">
            <p class="greeting">Hello <strong>{{ $sellerName }}</strong>,</p>
            <p class="message">Excellent news! You have received a new payment for your service.</p>

            <div class="amount-card">
                <div class="amount-label">Amount Received: </div>
                <div class="amount">{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</div>
            </div>

            <div class="details-card">
                <div class="detail-row">
                    <span class="detail-label">Order ID: </span>
                    <span class="detail-value">#{{ $order->order_id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment Method: </span>
                    <span class="detail-value">{{ ucfirst($payment->payment_gateway) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Buyer Name: </span>
                    <span class="detail-value">{{ $buyerName }}</span>
                </div>
                @if (isset($buyerUsername))
                    <div class="detail-row">
                        <span class="detail-label">Buyer Username: </span>
                        <span class="detail-value">{{ $buyerUsername }}</span>
                    </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">Date & Time: </span>
                    <span class="detail-value">{{ $payment->paid_at->format('M d, Y • h:i A') }}</span>
                </div>
            </div>

            <div class="info-box">
                <div class="info-title">Next Steps: </div>
                <ul class="info-list">
                    <li>Review the order requirements carefully</li>
                    <li>Begin working on order fulfillment</li>
                    <li>Keep the buyer updated on progress</li>
                    <li>Deliver high-quality work on time</li>
                </ul>
            </div>

            <div class="button-wrapper">
                <a href="{{ route('user.order.detail', $order->order_id) }}" class="cta-button">
                    View Order Details
                </a>
            </div>
        </div>

        <div class="footer">
            <p class="footer-text">This is an automated notification. Please do not reply to this email.</p>
            <p class="footer-text">If you have any questions, contact our support team.</p>
            <p class="footer-brand">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
