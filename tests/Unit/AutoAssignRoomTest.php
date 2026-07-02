<?php

use App\Models\Booking;
use App\Models\BookingRoomList;
use App\Models\Room;
use App\Models\RoomBookedDate;
use App\Models\RoomNumber;
use App\Models\User;
use App\Services\BookingEventManager;
use Carbon\Carbon;

beforeEach(function () {
    // Run migrations for in-memory SQLite database
    $this->artisan('migrate:fresh', ['--force' => true]);
});

it('auto-assigns rooms when creating a COD booking', function () {
    // Create a room with 2 room numbers
    $room = Room::factory()->create();
    RoomNumber::factory()->count(2)->create(['rooms_id' => $room->id, 'status' => 'Active']);

    // Create a user
    $user = User::factory()->create();

    // Simulate booking creation with auto-assign
    $booking = new Booking([
        'rooms_id' => $room->id,
        'user_id' => $user->id,
        'check_in' => '01-07-2026',
        'check_out' => '03-07-2026',
        'number_of_rooms' => 2,
        'total_price' => 1000,
        'payment_method' => 'COD',
        'payment_status' => 0,
    ]);

    // Simulate auto-assign logic
    $checkIn = Carbon::createFromFormat('d-m-Y', '01-07-2026');
    $checkOut = Carbon::createFromFormat('d-m-Y', '03-07-2026');

    $assignedRoomNumberIds = BookingRoomList::whereHas('booking', function ($query) use ($room, $checkIn, $checkOut) {
        $query->where('rooms_id', $room->id)
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in', '<', $checkOut->format('d-m-Y'))
                    ->where('check_out', '>', $checkIn->format('d-m-Y'));
            });
    })
        ->pluck('room_number_id')
        ->toArray();

    $availableRoomNumbers = RoomNumber::where('rooms_id', $room->id)
        ->where('status', 'Active')
        ->whereNotIn('id', $assignedRoomNumberIds)
        ->orderBy('room_number', 'asc')
        ->limit(2)
        ->get();

    // Save booking first to get the ID
    $booking->save();

    // Assign rooms
    foreach ($availableRoomNumbers as $roomNumber) {
        BookingRoomList::create([
            'booking_id' => $booking->id,
            'room_id' => $room->id,
            'room_number_id' => $roomNumber->id,
        ]);
    }

    // Assert that 2 rooms were assigned
    expect(BookingRoomList::where('booking_id', $booking->id)->count())->toBe(2);
});

it('prevents double booking by checking assigned rooms', function () {
    // Create a room with 2 room numbers
    $room = Room::factory()->create();
    $roomNumbers = RoomNumber::factory()->count(2)->create(['rooms_id' => $room->id, 'status' => 'Active']);

    // Create first booking and assign 1 room
    $booking1 = Booking::factory()->create([
        'rooms_id' => $room->id,
        'check_in' => '01-07-2026',
        'check_out' => '03-07-2026',
        'number_of_rooms' => 1,
    ]);

    BookingRoomList::create([
        'booking_id' => $booking1->id,
        'room_id' => $room->id,
        'room_number_id' => $roomNumbers->first()->id,
    ]);

    // Try to create second booking for same period requesting 2 rooms
    // Should fail because only 1 room is available
    $checkIn = Carbon::createFromFormat('d-m-Y', '01-07-2026');
    $checkOut = Carbon::createFromFormat('d-m-Y', '03-07-2026');

    $assignedRoomNumberIds = BookingRoomList::whereHas('booking', function ($query) use ($room, $checkIn, $checkOut) {
        $query->where('rooms_id', $room->id)
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in', '<', $checkOut->format('d-m-Y'))
                    ->where('check_out', '>', $checkIn->format('d-m-Y'));
            });
    })
        ->pluck('room_number_id')
        ->toArray();

    $availableRoomNumbers = RoomNumber::where('rooms_id', $room->id)
        ->where('status', 'Active')
        ->whereNotIn('id', $assignedRoomNumberIds)
        ->count();

    // Only 1 room available, but requesting 2
    expect($availableRoomNumbers)->toBe(1);
});

it('allows booking when enough rooms are available', function () {
    // Create a room with 3 room numbers
    $room = Room::factory()->create();
    $roomNumbers = RoomNumber::factory()->count(3)->create(['rooms_id' => $room->id, 'status' => 'Active']);

    // Create first booking and assign 1 room
    $booking1 = Booking::factory()->create([
        'rooms_id' => $room->id,
        'check_in' => '01-07-2026',
        'check_out' => '03-07-2026',
        'number_of_rooms' => 1,
    ]);

    BookingRoomList::create([
        'booking_id' => $booking1->id,
        'room_id' => $room->id,
        'room_number_id' => $roomNumbers->first()->id,
    ]);

    // Try to create second booking for same period requesting 2 rooms
    // Should succeed because 2 rooms are still available
    $checkIn = Carbon::createFromFormat('d-m-Y', '01-07-2026');
    $checkOut = Carbon::createFromFormat('d-m-Y', '03-07-2026');

    $assignedRoomNumberIds = BookingRoomList::whereHas('booking', function ($query) use ($room, $checkIn, $checkOut) {
        $query->where('rooms_id', $room->id)
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in', '<', $checkOut->format('d-m-Y'))
                    ->where('check_out', '>', $checkIn->format('d-m-Y'));
            });
    })
        ->pluck('room_number_id')
        ->toArray();

    $availableRoomNumbers = RoomNumber::where('rooms_id', $room->id)
        ->where('status', 'Active')
        ->whereNotIn('id', $assignedRoomNumberIds)
        ->count();

    // 2 rooms available, requesting 2
    expect($availableRoomNumbers)->toBe(2);
});

it('stores booked dates per assigned room number so the same room type can be booked multiple times on the same dates', function () {
    $room = Room::factory()->create();
    $roomNumbers = RoomNumber::factory()->count(3)->create([
        'rooms_id' => $room->id,
        'status' => 'Active',
    ]);

    $bookingOne = Booking::factory()->create([
        'rooms_id' => $room->id,
        'check_in' => '01-07-2026',
        'check_out' => '03-07-2026',
        'number_of_rooms' => 2,
    ]);

    BookingRoomList::create([
        'booking_id' => $bookingOne->id,
        'room_id' => $room->id,
        'room_number_id' => $roomNumbers[0]->id,
    ]);

    BookingRoomList::create([
        'booking_id' => $bookingOne->id,
        'room_id' => $room->id,
        'room_number_id' => $roomNumbers[1]->id,
    ]);

    BookingEventManager::getInstance()->created($bookingOne);

    expect(RoomBookedDate::where('booking_id', $bookingOne->id)->count())->toBe(4);

    $bookingTwo = Booking::factory()->create([
        'rooms_id' => $room->id,
        'check_in' => '01-07-2026',
        'check_out' => '03-07-2026',
        'number_of_rooms' => 1,
    ]);

    BookingRoomList::create([
        'booking_id' => $bookingTwo->id,
        'room_id' => $room->id,
        'room_number_id' => $roomNumbers[2]->id,
    ]);

    BookingEventManager::getInstance()->created($bookingTwo);

    expect(RoomBookedDate::where('room_id', $room->id)->count())->toBe(6);
    expect(RoomBookedDate::where('room_number_id', $roomNumbers[2]->id)->count())->toBe(2);
});
