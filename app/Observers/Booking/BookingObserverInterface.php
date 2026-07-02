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
     * Called when the deposit has been confirmed
     */
    public function depositConfirmed(Booking $booking): void;

    /**
     * Called when the remaining balance has been paid
     */
    public function paymentCompleted(Booking $booking): void;

    /**
     * Called when a booking is approved (Pending -> Complete)
     */
    public function approved(Booking $booking): void;

    /**
     * Called when a booking is cancelled
     */
    public function cancelled(Booking $booking): void;
}
