<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Completed</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.7; color: #1f2937; background: #f8fafc; padding: 24px;">
    <div
        style="max-width: 640px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">
        <div style="background: #1d4ed8; color: #fff; padding: 24px 28px;">
            <h1 style="margin: 0; font-size: 24px;">Final Payment Received</h1>
        </div>
        <div style="padding: 28px;">
            <p style="margin-top: 0;">Hi {{ $booking->name }},</p>
            <p>We have received the remaining balance for booking <strong>#{{ $booking->code }}</strong>. Your payment
                status has been updated to complete.</p>
            <p style="margin-bottom: 0;">Thank you for staying with HotelHub.</p>
        </div>
    </div>
</body>

</html>