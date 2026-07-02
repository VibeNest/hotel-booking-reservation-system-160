<?php

use App\Models\Booking;

it('calculates addon fee from booking totals', function () {
    $booking = new Booking([
        'subtotal' => 100,
        'discount' => 20,
        'total_price' => 145,
    ]);

    expect($booking->getAddonFee())->toBe(65.0);
});

it('exposes deposit helpers for cod bookings', function () {
    $booking = new Booking([
        'total_price' => 1000,
        'deposit_percentage' => 30,
        'deposit_amount' => 300,
        'remaining_amount' => 700,
        'payment_status' => 2,
    ]);

    expect($booking->getPaymentStatusLabel())->toBe('Deposit Paid')
        ->and($booking->getPaymentStatusColor())->toBe('warning')
        ->and($booking->isDepositPaid())->toBeTrue()
        ->and($booking->getDepositAmount())->toBe(300.0)
        ->and($booking->getRemainingAmount())->toBe(700.0);
});
