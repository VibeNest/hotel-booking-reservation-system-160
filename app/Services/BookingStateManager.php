<?php

namespace App\Services;

use App\Models\Booking;
use App\States\BookingState;
use App\States\CompleteBookingState;
use App\States\PendingBookingState;

class BookingStateManager
{
    /**
     * Get the state instance for a booking
     */
    public static function getState(Booking $booking): BookingState
    {
        return self::getStateFromValue($booking->status);
    }

    /**
     * Get state instance from integer value
     */
    public static function getStateFromValue(int $value): BookingState
    {
        return match ($value) {
            0 => new PendingBookingState,
            1 => new CompleteBookingState,
            default => new PendingBookingState,
        };
    }

    /**
     * Get all available states
     */
    public static function getAvailableStates(): array
    {
        return [
            new PendingBookingState,
            new CompleteBookingState,
        ];
    }

    /**
     * Approve a booking (transition Pending -> Complete)
     */
    public static function approve(Booking $booking): void
    {
        $state = self::getState($booking);

        if (! $state->canApprove()) {
            throw new \Exception("Cannot approve booking in {$state->label()} status");
        }

        $state->approve($booking);
    }

    /**
     * Cancel a booking
     */
    public static function cancel(Booking $booking): void
    {
        $state = self::getState($booking);

        if (! $state->canCancel()) {
            throw new \Exception("Cannot cancel booking in {$state->label()} status");
        }

        $state->cancel($booking);
    }

    /**
     * Get state label for display
     */
    public static function getLabel(Booking $booking): string
    {
        return self::getState($booking)->label();
    }

    /**
     * Get state color for UI
     */
    public static function getColor(Booking $booking): string
    {
        return self::getState($booking)->color();
    }
}
