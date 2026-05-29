<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\RoomBookedDate;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class FrontendRoomController extends Controller
{
    // Frontend Room All Method
    public function AllFrontendRoomList()
    {

        $rooms = Room::latest()->paginate(6);
        return view('frontend.room.all_rooms', compact('rooms'));
    }

    // Frontend Room Details Method
    public function RoomDetailsPage($id)
    {
        $roomdetails = Room::find($id);
        $facilities = Facility::where('rooms_id', $id)->get();
        $multiImages = MultiImage::where('rooms_id', $id)->get();

        $otherRooms = Room::where('id', '!=', $id)->orderBy('id', 'DESC')->limit(2)->get();

        return view('frontend.room.room_details', compact(
            'roomdetails',
            'facilities',
            'multiImages',
            'otherRooms'
        ));
    }

    // Booking Search Method
    public function BookingSearch(Request $request)
    {
        // Lưu dữ liệu vào session để hiển thị lại trên form
        $request->flash();

        // Chuyển đổi string sang timestamp
        $startDate = date('d-m-Y', strtotime($request->check_in));
        $endDate = date('d-m-Y', strtotime($request->check_out));

        // Trừ đi 1 ngày checkout => để không tính ngày checkout vào danh sách ngày booking
        $allDate = Carbon::create($endDate)->subDay();

        // Tạo danh sách các ngày booking
        $day_period = CarbonPeriod::create($startDate, $allDate);

        $date_array = [];

        // Lưu các ngày booking vào trong mảng
        foreach ($day_period as $period) {
            array_push($date_array, date('Y-m-d', strtotime($period)));
        }

        // Lấy danh sách booking_id không trùng nhau thỏa mãn điều kiện ngày booking trùng với ngày trong mảng $date_array
        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $date_array)->distinct()->pluck('booking_id')->toArray();

        // Lấy danh sách phòng đang hoạt động
        $rooms = Room::withCount('rooms_numbers')->where('status', 1)->get();

        $availableRooms = [];

        foreach ($rooms as $room) {
            // Lấy danh sách booking đã đặt
            $bookings = Booking::withCount('assign_rooms')->whereIn('id', $check_date_booking_ids)->where('rooms_id', $room->id)->get()->toArray();

            // Tính tổng số phòng đã đặt
            $total_book_room = array_sum(array_column($bookings, 'assign_rooms_count'));

            // Số phòng còn trống = tổng số phòng - số phòng đã đặt
            $available_room = $room->rooms_numbers_count - $total_book_room;

            // Tổng người
            $total_persons = $room->total_adult + $room->total_child;

            if ($available_room > 0 && $request->person <= $total_persons) {
                // thêm available_room vào object
                $room->available_room = $available_room;

                $availableRooms[] = $room;
            }
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 6;

        $currentItems = array_slice($availableRooms, ($currentPage - 1) * $perPage, $perPage);

        $paginatedRooms = new LengthAwarePaginator(
            $currentItems,
            count($availableRooms),
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );

        return view('frontend.room.search_room', ['rooms' => $paginatedRooms]);
    }

    // Search Room Details Method
    public function SearchRoomDetails(Request $request, $id)
    {
        // Lưu dữ liệu vào session để hiển thị lại trên form
        $request->flash();

        $roomdetails = Room::find($id);
        $facilities = Facility::where('rooms_id', $id)->get();
        $multiImages = MultiImage::where('rooms_id', $id)->get();

        $otherRooms = Room::where('id', '!=', $id)->orderBy('id', 'DESC')->limit(2)->get();
        $room_id = $id;
        $total_person = $roomdetails->total_adult + $roomdetails->total_child;

        return view('frontend.room.search_room_details', compact(
            'roomdetails',
            'facilities',
            'multiImages',
            'otherRooms',
            'room_id',
            'total_person'
        ));
    }

    // Check Room Availability Method
    public function CheckRoomAvailability(Request $request)
    {
        // Chuyển đổi string sang timestamp
        $startDate = date('d-m-Y', strtotime($request->check_in));
        $endDate = date('d-m-Y', strtotime($request->check_out));

        // Trừ đi 1 ngày checkout => để không tính ngày checkout vào danh sách ngày booking
        $allDate = Carbon::create($endDate)->subDay();

        // Tạo danh sách các ngày booking
        $day_period = CarbonPeriod::create($startDate, $allDate);

        $date_array = [];

        // Lưu các ngày booking vào trong mảng
        foreach ($day_period as $period) {
            array_push($date_array, date('Y-m-d', strtotime($period)));
        }

        // Lấy danh sách booking_id không trùng nhau thỏa mãn điều kiện ngày booking trùng với ngày trong mảng $date_array
        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $date_array)->distinct()->pluck('booking_id')->toArray();

        // Lấy tổng số phòng
        $room = Room::withCount('rooms_numbers')->find($request->room_id);

        // Lấy danh sách booking đã đặt
        $bookings = Booking::withCount('assign_rooms')->whereIn('id', $check_date_booking_ids)->where('rooms_id', $room->id)->get()->toArray();

        // Tính tổng số phòng đã đặt
        $total_book_room = array_sum(array_column($bookings, 'assign_rooms_count'));

        // Số phòng còn trống = tổng số phòng - số phòng đã đặt
        $available_room = $room->rooms_numbers_count - $total_book_room;

        // Tính số nights giữa check_in và check_out
        $toDate = Carbon::parse($request->check_in);
        $fromDate = Carbon::parse($request->check_out);
        $nights = $toDate->diffInDays($fromDate);

        return response()->json([
            'available_room' => $available_room,
            'total_nights' => $nights,
        ]);
    }
}
