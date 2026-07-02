<?php

namespace App\Observers\Booking\Observers;

use App\Models\Booking;
use App\Models\BookingRoomList;
use App\Models\RoomBookedDate;
use App\Observers\Booking\BookingObserverInterface;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class RoomAvailabilityUpdaterObserver implements BookingObserverInterface
{
    /**
     * Create booked dates when a booking is created
     */
    public function created(Booking $booking): void
    {
        $startDate = Carbon::createFromFormat('d-m-Y', $booking->check_in);
        $endDate = Carbon::createFromFormat('d-m-Y', $booking->check_out);
        $endDate = $endDate->subDay();

        $bookDates = [];
        foreach (CarbonPeriod::create($startDate, $endDate) as $period) {
            $bookDates[] = $period->format('Y-m-d');
        }

        if (empty($bookDates)) {
            return;
        }

        $assignedRoomNumberIds = BookingRoomList::where('booking_id', $booking->id)
            ->pluck('room_number_id')
            ->filter()
            ->unique()
            ->values();

        if ($assignedRoomNumberIds->isNotEmpty()) {
            foreach ($assignedRoomNumberIds as $roomNumberId) {
                foreach ($bookDates as $bookDate) {
                    $bookedDates = new RoomBookedDate;
                    $bookedDates->booking_id = $booking->id;
                    $bookedDates->room_id = $booking->rooms_id;
                    $bookedDates->room_number_id = $roomNumberId;
                    $bookedDates->book_date = $bookDate;
                    $bookedDates->save();
                }
            }

            return;
        }

        foreach ($bookDates as $bookDate) {
            $bookedDates = new RoomBookedDate;
            $bookedDates->booking_id = $booking->id;
            $bookedDates->room_id = $booking->rooms_id;
            $bookedDates->book_date = $bookDate;
            $bookedDates->save();
        }
    }

    /**
     * No availability changes on deposit confirmation
     */
    public function depositConfirmed(Booking $booking): void
    {
        // No action needed
    }

    /**
     * No availability changes on final payment completion
     */
    public function paymentCompleted(Booking $booking): void
    {
        // No action needed
    }

    /**
     * No specific action on approval for availability
     */
    public function approved(Booking $booking): void
    {
        // Room availability already handled at creation time
    }

    /**
     * Release booked dates when a booking is cancelled
     */
    public function cancelled(Booking $booking): void
    {
        RoomBookedDate::where('booking_id', $booking->id)->delete();
        BookingRoomList::where('booking_id', $booking->id)->delete();
    }
}
