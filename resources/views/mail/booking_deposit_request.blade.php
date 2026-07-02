<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deposit Request</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.7; color: #1f2937; background: #f8fafc; padding: 24px;">
    <div
        style="max-width: 640px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">
        <div style="background: #0f766e; color: #fff; padding: 24px 28px;">
            <h1 style="margin: 0; font-size: 24px;">HotelHub Deposit Request</h1>
        </div>
        <div style="padding: 28px;">
            <p style="margin-top: 0;">Hi {{ $booking->name }},</p>
            <p>Your booking has been created successfully. To hold your room, please transfer a deposit of
                <strong>{{ $booking->getDepositPercentage() }}%</strong> of the total booking amount.
            </p>

            <table width="100%" style="border-collapse: collapse; margin: 18px 0;">
                <tr>
                    <td style="padding: 8px 12px; background: #f3f4f6; border: 1px solid #e5e7eb;">Booking No</td>
                    <td style="padding: 8px 12px; border: 1px solid #e5e7eb;">{{ $booking->code }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 12px; background: #f3f4f6; border: 1px solid #e5e7eb;">Deposit Amount</td>
                    <td style="padding: 8px 12px; border: 1px solid #e5e7eb;">
                        ${{ number_format($booking->getDepositAmount(), 2) }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 12px; background: #f3f4f6; border: 1px solid #e5e7eb;">Remaining</td>
                    <td style="padding: 8px 12px; border: 1px solid #e5e7eb;">
                        ${{ number_format($booking->getRemainingAmount(), 2) }}</td>
                </tr>
            </table>

            <div style="background: #eff6ff; border-left: 4px solid #2563eb; padding: 16px 18px; margin: 20px 0;">
                <p style="margin: 0 0 8px;"><strong>Bank transfer details</strong></p>
                <p style="margin: 0;">Bank: MB</p>
                <p style="margin: 0;">Account name: VU VAN THANH TUNG</p>
                <p style="margin: 0;">Account number: 1888803092004</p>
                <p style="margin: 0;">Transfer note: Deposit {{ $booking->code }}</p>
            </div>

            <div style="text-align: center; margin: 24px 0;">
                <p style="margin: 0 0 12px; font-weight: bold; color: #0f172a;">Scan to pay deposit</p>
                <img src="{{ $message->embed(public_path('upload/qr/qr_code.jpg')) }}" alt="Bank QR code"
                    style="max-width: 100%; width: 320px; height: auto; border: 1px solid #e5e7eb; border-radius: 12px; padding: 10px; background: #fff;">
            </div>

            <p style="margin-bottom: 0;">Once the deposit is received, we will confirm and keep the room for you.</p>
        </div>
    </div>
</body>

</html>