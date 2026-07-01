<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; color: #1f2937; line-height: 1.6;">
    <p>Xin chào {{ $name }},</p>

    <p>Mã OTP để kích hoạt tài khoản của bạn là:</p>

    <div style="font-size: 28px; font-weight: 700; letter-spacing: 4px; margin: 16px 0; color: #111827;">
        {{ $otpCode }}
    </div>

    <p>Mã này có hiệu lực trong {{ $expiresMinutes }} phút.</p>

    <p>Nếu bạn không yêu cầu đăng ký, hãy bỏ qua email này.</p>
</body>

</html>