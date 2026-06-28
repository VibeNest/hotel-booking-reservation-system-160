<?php

namespace App\Observers\Booking;

use App\Models\Booking;

class BookingSubject implements BookingSubjectInterface
{
    /**
     * List of observers
     *
     * @var array<int, BookingObserverInterface>
     */
    private array $observers = [];

    /**
     * Attach an observer
     */
    public function attach(BookingObserverInterface $observer): void
    {
        $this->observers[] = $observer;
    }

    /**
     * Detach an observer
     */
    public function detach(BookingObserverInterface $observer): void
    {
        $this->observers = array_filter(
            $this->observers,
            fn ($existing) => $existing !== $observer
        );
    }

    /**
     * Notify all observers that a booking was created
     */
    public function notifyCreated(Booking $booking): void
    {
        foreach ($this->observers as $observer) {
            $observer->created($booking);
        }
    }

    /**
     * Notify all observers that a booking was approved
     */
    public function notifyApproved(Booking $booking): void
    {
        foreach ($this->observers as $observer) {
            $observer->approved($booking);
        }
    }

    /**
     * Notify all observers that a booking was cancelled
     */
    public function notifyCancelled(Booking $booking): void
    {
        foreach ($this->observers as $observer) {
            $observer->cancelled($booking);
        }
    }

    /**
     * Get all attached observers
     *
     * @return array<int, BookingObserverInterface>
     */
    public function getObservers(): array
    {
        return $this->observers;
    }
}
