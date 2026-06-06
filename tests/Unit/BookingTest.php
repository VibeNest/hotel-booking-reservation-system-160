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
