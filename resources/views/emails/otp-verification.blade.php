<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #4CAF50;
            text-align: center;
            padding: 20px;
            background: #f5f5f5;
            border-radius: 5px;
            margin: 20px 0;
            letter-spacing: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello {{ $userName }}!</h2>
        
        <p>Thank you for registering. Your OTP code for email verification is:</p>
        
        <div class="otp-code">
            {{ $otpCode }}
        </div>
        
        <p><strong>This code will expire at:</strong> {{ $expiresAt->format('d M Y, h:i A') }}</p>
        
        <p>Please enter this code to verify your email address.</p>
        
        <p><strong>Security Note:</strong> Do not share this code with anyone. Our team will never ask for this code.</p>
        
        <div class="footer">
            <p>If you did not request this code, please ignore this email.</p>
        </div>
    </div>
</body>
</html>