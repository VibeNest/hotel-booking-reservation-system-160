<?php

namespace App\States;

use App\Models\Booking;

class CompleteBookingState implements BookingState
{
    public function name(): string
    {
        return 'complete';
    }

    public function label(): string
    {
        return 'Complete';
    }

    public function color(): string
    {
        return 'success';
    }

    public function value(): int
    {
        return 1;
    }

    public function approve(Booking $booking): void
    {
        // Already complete, no action needed
    }

    public function cancel(Booking $booking): void
    {
        // Prevent cancellation of completed bookings
        throw new \Exception('Cannot cancel a completed booking');
    }

    public function canApprove(): bool
    {
        return false;
    }

    public function canCancel(): bool
    {
        return false;
    }
}
