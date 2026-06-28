<?php

namespace App\Observers\Booking;

use App\Models\Booking;

interface BookingObserverInterface
{
    /**
     * Called when a booking is created (Pending status)
     */
    public function created(Booking $booking): void;

    /**
     * Called when a booking is approved (Pending -> Complete)
     */
    public function approved(Booking $booking): void;

    /**
     * Called when a booking is cancelled
     */
    public function cancelled(Booking $booking): void;
}
