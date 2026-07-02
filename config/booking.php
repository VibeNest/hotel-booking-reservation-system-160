<?php

return [
    'cod_deposit_percentage' => (int) env('COD_DEPOSIT_PERCENTAGE', 30),
    'bank_name' => env('BOOKING_BANK_NAME', 'MB'),
    'bank_account_name' => env('BOOKING_BANK_ACCOUNT_NAME', 'VU VAN THANH TUNG'),
    'bank_account_number' => env('BOOKING_BANK_ACCOUNT_NUMBER', '1888803092004'),
    'bank_qr_path' => env('BOOKING_BANK_QR_PATH', 'images/booking-deposit-qr.png'),
    'bank_transfer_note' => env('BOOKING_BANK_TRANSFER_NOTE', ''),
];
