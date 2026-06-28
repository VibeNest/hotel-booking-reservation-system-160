<?php

namespace App\Observers\Booking;

use App\Models\Booking;

interface BookingSubjectInterface
{
    /**
     * Attach an observer
     */
    public function attach(BookingObserverInterface $observer): void;

    /**
     * Detach an observer
     */
    public function detach(BookingObserverInterface $observer): void;

    /**
     * Notify all observers that a booking was created
     */
    public function notifyCreated(Booking $booking): void;

    /**
     * Notify all observers that a booking was approved
     */
    public function notifyApproved(Booking $booking): void;

    /**
     * Notify all observers that a booking was cancelled
     */
    public function notifyCancelled(Booking $booking): void;
}
