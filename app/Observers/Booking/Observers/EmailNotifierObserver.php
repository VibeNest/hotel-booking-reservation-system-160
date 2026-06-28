<?php

namespace App\Observers\Booking\Observers;

use App\Mail\BookConfirm;
use App\Models\Booking;
use App\Observers\Booking\BookingObserverInterface;
use Illuminate\Support\Facades\Mail;

class EmailNotifierObserver implements BookingObserverInterface
{
    /**
     * No email sent when booking is created
     * Admin notification only (handled by AdminNotifierObserver)
     * Email will be sent when booking is approved
     */
    public function created(Booking $booking): void
    {
        // No email sent at creation time
    }

    /**
     * Send completion email when a booking is approved
     */
    public function approved(Booking $booking): void
    {
        $data = [
            'check_in' => $booking->check_in,
            'check_out' => $booking->check_out,
            'name' => $booking->name,
            'email' => $booking->email,
            'phone' => $booking->phone,
        ];

        Mail::to($booking->email)->send(new BookConfirm($data));
    }

    /**
     * Send cancellation email when a booking is cancelled
     */
    public function cancelled(Booking $booking): void
    {
        $data = [
            'check_in' => $booking->check_in,
            'check_out' => $booking->check_out,
            'name' => $booking->name,
            'email' => $booking->email,
            'phone' => $booking->phone,
        ];

        Mail::to($booking->email)->send(new BookConfirm($data));
    }
}
