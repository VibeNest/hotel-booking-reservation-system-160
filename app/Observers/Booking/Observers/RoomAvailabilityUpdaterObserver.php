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

        $dayPeriod = CarbonPeriod::create($startDate, $endDate);

        foreach ($dayPeriod as $period) {
            $bookedDates = new RoomBookedDate;
            $bookedDates->booking_id = $booking->id;
            $bookedDates->room_id = $booking->rooms_id;
            $bookedDates->book_date = $period->format('Y-m-d');
            $bookedDates->save();
        }
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
