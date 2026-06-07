<?php

namespace App\Specifications;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomBookedDate;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AvailableDateSpecification implements RoomSpecification
{
    private $checkIn;
    private $checkOut;

    public function __construct($checkIn, $checkOut)
    {
        $this->checkIn = $checkIn;
        $this->checkOut = $checkOut;
    }

    public function isSatisfiedBy(Room $room): bool
    {
        // Chuyển đổi string sang date
        $startDate = date('d-m-Y', strtotime($this->checkIn));
        $endDate = date('d-m-Y', strtotime($this->checkOut));

        // Trừ đi 1 ngày checkout
        $allDate = Carbon::create($endDate)->subDay();

        // Tạo danh sách ngày cần kiểm tra
        $dayPeriod = CarbonPeriod::create($startDate, $allDate);

        $dateArray = [];

        foreach ($dayPeriod as $period) {
            $dateArray[] = $period->format('Y-m-d');
        }

        // Lấy booking_id đã đặt trong khoảng ngày đó
        $bookingIds = RoomBookedDate::whereIn(
            'book_date',
            $dateArray
        )
        ->distinct()
        ->pluck('booking_id')
        ->toArray();

        // Lấy các booking của room hiện tại
        $bookings = Booking::withCount('assign_rooms')
            ->whereIn('id', $bookingIds)
            ->where('rooms_id', $room->id)
            ->get()
            ->toArray();

        // Tổng số phòng đã đặt
        $totalBookedRoom = array_sum(
            array_column($bookings, 'assign_rooms_count')
        );

        // Tổng số phòng hiện có
        $totalRoom = $room->rooms_numbers_count;

        // Số phòng còn trống
        $availableRoom = $totalRoom - $totalBookedRoom;

        // Gắn thêm thuộc tính để View có thể dùng
        $room->available_room = $availableRoom;

        return $availableRoom > 0;
    }
}