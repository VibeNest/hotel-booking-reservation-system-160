<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deposit Confirmed</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.7; color: #1f2937; background: #f8fafc; padding: 24px;">
    <div
        style="max-width: 640px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">
        <div style="background: #16a34a; color: #fff; padding: 24px 28px;">
            <h1 style="margin: 0; font-size: 24px;">Deposit Received</h1>
        </div>
        <div style="padding: 28px;">
            <p style="margin-top: 0;">Hi {{ $booking->name }},</p>
            <p>We have received your deposit for booking <strong>#{{ $booking->code }}</strong>. Your room is now
                reserved and held for your stay.</p>
            <p style="margin-bottom: 0;">Remaining balance:
                <strong>${{ number_format($booking->getRemainingAmount(), 2) }}</strong></p>
        </div>
    </div>
</body>

</html>