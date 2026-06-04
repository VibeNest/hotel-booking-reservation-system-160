<?php

namespace App\States;

use App\Models\Booking;

class PendingBookingState implements BookingState
{
    public function name(): string
    {
        return 'pending';
    }

    public function label(): string
    {
        return 'Pending';
    }

    public function color(): string
    {
        return 'danger';
    }

    public function value(): int
    {
        return 0;
    }

    public function approve(Booking $booking): void
    {
        $booking->status = 1;
        $booking->save();
    }

    public function cancel(Booking $booking): void
    {
        // Log or handle cancellation for pending bookings
        $booking->status = 0;
        $booking->save();
    }

    public function canApprove(): bool
    {
        return true;
    }

    public function canCancel(): bool
    {
        return true;
    }
}
