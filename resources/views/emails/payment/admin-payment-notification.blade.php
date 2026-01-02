<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin: New Payment</title>
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
            max-width: 650px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(133, 62, 255, 0.3);
        }

        .header {
            background: linear-gradient(135deg, #f97316 0%, #cb2c30 100%);
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

        .badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 12px;
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
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.08) 0%, rgba(203, 44, 48, 0.08) 100%);
            border: 2px solid #f97316;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin: 24px 0;
        }

        .amount-label {
            font-size: 14px;
            color: #cb2c30;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .amount {
            font-size: 42px;
            font-weight: 800;
            background: linear-gradient(135deg, #f97316 0%, #cb2c30 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #1b1b1b;
            margin: 32px 0 16px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #853eff;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin: 24px 0;
        }

        .detail-card {
            background: #f9fafb;
            border-radius: 8px;
            padding: 16px;
        }

        .detail-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .detail-value {
            font-size: 15px;
            color: #1b1b1b;
            font-weight: 600;
        }

        .detail-card-full {
            grid-column: 1 / -1;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #853eff 0%, #ff2e91 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 24px auto;
            text-align: center;
            box-shadow: 0 4px 12px rgba(133, 62, 255, 0.4);
            transition: transform 0.2s;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(133, 62, 255, 0.5);
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

        @media (max-width: 600px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="header">
            <div class="header-content">
                <div class="icon">🔔</div>
                <h1>New Payment Received</h1>
                <div class="badge">Admin Notification</div>
            </div>
        </div>

        <div class="content">
            <p class="greeting">Hello Admin,</p>
            <p class="message">A new payment transaction has been successfully processed on the platform.</p>

            <div class="amount-card">
                <div class="amount-label">Transaction Amount</div>
                <div class="amount">{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</div>
            </div>

            <div class="section-title">📋 Transaction Details</div>
            <div class="details-grid">
                <div class="detail-card">
                    <div class="detail-label">Order ID: </div>
                    <div class="detail-value">#{{ $order->order_id }}</div>
                </div>
                <div class="detail-card">
                    <div class="detail-label">Payment ID: </div>
                    <div class="detail-value">{{ $payment->payment_id }}</div>
                </div>
                <div class="detail-card">
                    <div class="detail-label">Payment Gateway: </div>
                    <div class="detail-value">{{ ucfirst($payment->payment_gateway) }}</div>
                </div>
                <div class="detail-card">
                    <div class="detail-label">Transaction Date: </div>
                    <div class="detail-value">{{ $payment->paid_at->format('M d, Y • h:i A') }}</div>
                </div>
            </div>

            <div class="section-title">👤 Buyer Information</div>
            <div class="details-grid">
                <div class="detail-card">
                    <div class="detail-label">Name: </div>
                    <div class="detail-value">{{ $buyerName }}</div>
                </div>
                @if (isset($buyerUsername))
                    <div class="detail-card">
                        <div class="detail-label">Username: </div>
                        <div class="detail-value">{{ $buyerUsername }}</div>
                    </div>
                @endif
                <div class="detail-card detail-card-full">
                    <div class="detail-label">Email: </div>
                    <div class="detail-value">{{ $buyerEmail }}</div>
                </div>
            </div>

            <div class="section-title">🏪 Seller Information</div>
            <div class="details-grid">
                <div class="detail-card">
                    <div class="detail-label">Name: </div>
                    <div class="detail-value">{{ $sellerName }}</div>
                </div>
                @if (isset($sellerUsername))
                    <div class="detail-card">
                        <div class="detail-label">Username: </div>
                        <div class="detail-value">{{ $sellerUsername }}</div>
                    </div>
                @endif
                <div class="detail-card detail-card-full">
                    <div class="detail-label">Email: </div>
                    <div class="detail-value">{{ $sellerEmail }}</div>
                </div>
            </div>

            <div class="button-wrapper">
                <a href="{{ route('admin.orders.show', $order->order_id) }}" class="cta-button">
                    View in Admin Panel
                </a>
            </div>
        </div>

        <div class="footer">
            <p class="footer-text">This is an automated admin notification from {{ config('app.name') }}.</p>
            <p class="footer-text">Please review the transaction in your admin dashboard.</p>
            <p class="footer-brand">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
