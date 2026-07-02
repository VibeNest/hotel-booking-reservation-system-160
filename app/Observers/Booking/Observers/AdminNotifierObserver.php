<?php

namespace App\Observers\Booking\Observers;

use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingComplete;
use App\Observers\Booking\BookingObserverInterface;
use Illuminate\Support\Facades\Notification;

class AdminNotifierObserver implements BookingObserverInterface
{
    /**
     * Notify admin when a booking is created
     */
    public function created(Booking $booking): void
    {
        $admin = User::where('role', 'admin')->get();
        $user = User::find($booking->user_id);

        Notification::send($admin, new BookingComplete(
            name: $booking->name,
            userImage: $user?->photo,
            userId: $booking->user_id,
        ));
    }

    public function depositConfirmed(Booking $booking): void
    {
        // No admin notification needed for deposit confirmation
    }

    public function paymentCompleted(Booking $booking): void
    {
        // No admin notification needed for payment completion
    }

    /**
     * No admin notification when booking is approved
     * Only send email to customer (handled by EmailNotifierObserver)
     */
    public function approved(Booking $booking): void
    {
        // No action needed - email only
    }

    /**
     * No admin notification when booking is cancelled
     * Only send email to customer (handled by EmailNotifierObserver)
     */
    public function cancelled(Booking $booking): void
    {
        // No action needed - email only
    }
}
