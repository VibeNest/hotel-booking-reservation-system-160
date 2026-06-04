<?php

namespace App\States;

use App\Models\Booking;

interface BookingState
{
    /**
     * Get the state name
     */
    public function name(): string;

    /**
     * Get the state label for display
     */
    public function label(): string;

    /**
     * Get the badge color for UI
     */
    public function color(): string;

    /**
     * Get the integer value for database
     */
    public function value(): int;

    /**
     * Approve the booking (Pending -> Complete)
     */
    public function approve(Booking $booking): void;

    /**
     * Cancel the booking
     */
    public function cancel(Booking $booking): void;

    /**
     * Check if booking can be approved
     */
    public function canApprove(): bool;

    /**
     * Check if booking can be cancelled
     */
    public function canCancel(): bool;
}
