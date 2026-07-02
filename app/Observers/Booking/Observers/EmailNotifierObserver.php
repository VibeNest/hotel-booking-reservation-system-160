<?php

namespace App\Observers\Booking\Observers;

use App\Mail\BookConfirm;
use App\Mail\BookingDepositConfirmedMail;
use App\Mail\BookingDepositRequestMail;
use App\Mail\BookingPaymentCompletedMail;
use App\Models\Booking;
use App\Observers\Booking\BookingObserverInterface;
use Illuminate\Support\Facades\Mail;

class EmailNotifierObserver implements BookingObserverInterface
{
    /**
     * Send deposit request email when COD booking is created.
     */
    public function created(Booking $booking): void
    {
        if ($booking->payment_method !== 'COD' || !$booking->isDepositPending()) {
            return;
        }

        Mail::to($booking->email)->send(new BookingDepositRequestMail($booking));
    }

    /**
     * Send confirmation email when the deposit has been received.
     */
    public function depositConfirmed(Booking $booking): void
    {
        Mail::to($booking->email)->send(new BookingDepositConfirmedMail($booking));
    }

    /**
     * Send completion email when the remaining balance has been paid.
     */
    public function paymentCompleted(Booking $booking): void
    {
        Mail::to($booking->email)->send(new BookingPaymentCompletedMail($booking));
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
