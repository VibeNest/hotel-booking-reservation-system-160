<?php

namespace App\Services;

use App\Models\Booking;
use App\Observers\Booking\BookingObserverInterface;
use App\Observers\Booking\BookingSubject;

class BookingEventManager
{
    private static ?BookingEventManager $instance = null;

    private BookingSubject $subject;

    private function __construct()
    {
        $this->subject = new BookingSubject;
    }

    /**
     * Get the singleton instance
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Attach an observer
     */
    public function attach(BookingObserverInterface $observer): void
    {
        $this->subject->attach($observer);
    }

    /**
     * Detach an observer
     */
    public function detach(BookingObserverInterface $observer): void
    {
        $this->subject->detach($observer);
    }

    /**
     * Fire the created event
     */
    public function created(Booking $booking): void
    {
        $this->subject->notifyCreated($booking);
    }

    /**
     * Fire the deposit confirmed event
     */
    public function depositConfirmed(Booking $booking): void
    {
        $this->subject->notifyDepositConfirmed($booking);
    }

    /**
     * Fire the payment completed event
     */
    public function paymentCompleted(Booking $booking): void
    {
        $this->subject->notifyPaymentCompleted($booking);
    }

    /**
     * Fire the approved event
     */
    public function approved(Booking $booking): void
    {
        $this->subject->notifyApproved($booking);
    }

    /**
     * Fire the cancelled event
     */
    public function cancelled(Booking $booking): void
    {
        $this->subject->notifyCancelled($booking);
    }
}
