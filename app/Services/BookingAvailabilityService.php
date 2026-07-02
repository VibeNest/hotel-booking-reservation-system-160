<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingRoomList;
use App\Models\Room;
use App\Models\RoomBookedDate;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class BookingAvailabilityService
{
    /**
     * Validate and lock room availability for a booking.
     *
     * Uses pessimistic locking (SELECT ... FOR UPDATE) inside a transaction
     * to prevent race conditions when two users try to book the same room.
     *
     * @param  string  $checkIn  Format: d-m-Y
     * @param  string  $checkOut  Format: d-m-Y
     * @param  int|null  $excludeBookingId  Exclude a booking ID (for updates)
     * @return int Number of available rooms
     *
     * @throws RuntimeException When not enough rooms are available
     */
    public function validateAndLockAvailability(
        int $roomId,
        string $checkIn,
        string $checkOut,
        int $numberOfRoomsRequested,
        ?int $excludeBookingId = null
    ): int {
        // Parse dates
        $startDate = Carbon::createFromFormat('d-m-Y', $checkIn);
        $endDate = Carbon::createFromFormat('d-m-Y', $checkOut);
        $endDateExclusive = $endDate->copy()->subDay();

        // Generate the list of dates that need to be checked
        $datePeriod = CarbonPeriod::create($startDate, $endDateExclusive);
        $dateArray = [];
        foreach ($datePeriod as $period) {
            $dateArray[] = $period->format('Y-m-d');
        }

        if (empty($dateArray)) {
            return 0;
        }

        // Use a transaction with pessimistic locking to prevent race conditions
        return DB::transaction(function () use ($roomId, $dateArray, $numberOfRoomsRequested, $excludeBookingId) {
            // Step 1: Lock the relevant rows in room_booked_dates with FOR UPDATE
            $lockedQuery = RoomBookedDate::whereIn('book_date', $dateArray)
                ->where('room_id', $roomId);

            if ($excludeBookingId !== null) {
                $lockedQuery->where('booking_id', '!=', $excludeBookingId);
            }

            // This is the critical locking operation
            $lockedBookings = $lockedQuery->lockForUpdate()->get();

            // Step 2: Get the distinct booking IDs from locked results
            $bookingIds = $lockedBookings->pluck('booking_id')->unique()->toArray();

            // Step 3: Get the sum of ACTUALLY ASSIGNED rooms for those bookings
            // This ensures we count only rooms that have been physically assigned (not just booked)
            $totalAssignedRooms = 0;
            if (!empty($bookingIds)) {
                $totalAssignedRooms = (int) BookingRoomList::whereIn('booking_id', $bookingIds)
                    ->when($excludeBookingId !== null, function ($q) use ($excludeBookingId) {
                        return $q->where('booking_id', '!=', $excludeBookingId);
                    })
                    ->count();
            }

            // Step 4: Get total rooms available
            $room = Room::select('id')->withCount('rooms_numbers')->find($roomId);

            if (!$room) {
                throw new ModelNotFoundException("Room #{$roomId} not found.");
            }

            $totalRoom = (int) $room->rooms_numbers_count;
            $availableRoom = $totalRoom - $totalAssignedRooms;

            // Step 5: Check if enough rooms are available
            if ($availableRoom < $numberOfRoomsRequested) {
                throw new RuntimeException(
                    "Not enough rooms available. Requested: {$numberOfRoomsRequested}, Available: {$availableRoom}"
                );
            }

            return $availableRoom;
        });
    }
}
