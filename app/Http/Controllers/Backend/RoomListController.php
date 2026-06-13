<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomBookedDate;
use App\Models\RoomNumber;
use App\Models\RoomType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomListController extends Controller
{
    // View Room List Method
    public function ViewRoomList()
    {
        // Lấy danh sách tất cả các phòng còn trống và đã đặt
        $room_number_list = RoomNumber::with(['room_type', 'last_booking.booking:id,check_in,check_out,status,code,name,phone'])
            ->orderBy('room_type_id', 'asc')
            ->leftJoin('room_types', 'room_types.id', 'room_numbers.room_type_id')
            ->leftJoin('booking_room_lists', 'booking_room_lists.room_number_id', 'room_numbers.id')
            ->leftJoin('bookings', 'bookings.id', 'booking_room_lists.booking_id')
            ->select(
                'room_numbers.*',
                'room_numbers.id as id',
                'room_types.name',
                'bookings.id as booking_id',
                'bookings.check_in',
                'bookings.check_out',
                'bookings.name as customer_name',
                'bookings.phone as customer_phone',
                'bookings.status as booking_status',
                'bookings.code as booking_number',
            )
            ->orderBy('room_types.id', 'asc')
            ->orderBy('bookings.id', 'desc')
            ->get();

        return view('backend.all_room.room_list.view_room_list', compact('room_number_list'));
    }

    // Add Room List Method
    public function AddRoomList()
    {
        $room_types = RoomType::all();

        return view('backend.all_room.room_list.add_room_list', compact('room_types'));
    }

    // Store Room List Method
    public function StoreRoomList(Request $request)
    {
        // Nếu số lượng phòng chọn vượt quá số lượng phòng còn trống
        if ($request->available_room < $request->number_of_rooms) {
            $notification = [
                'message' => 'You enter maximum number of rooms!',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }

        $room = Room::find($request['rooms_id']);

        // Số lượng người chọn vượt quá số lượng người mà phòng đó chứa
        if ($room->room_capacity < $request->person) {
            $notification = [
                'message' => 'You enter maximum number of guests!',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }

        // Tính số đêm
        $toDate = Carbon::parse($request['check_in']);
        $fromDate = Carbon::parse($request['check_out']);
        $total_nights = $toDate->diffInDays($fromDate);

        // Tính tiền
        $subtotal = $room->price * $total_nights * $request->number_of_rooms;

        // Discount
        $discount = ($room->discount / 100) * $subtotal;

        // Total Price
        $total_price = $subtotal - $discount;

        // Generate booking code 9 số
        $code = rand(100000000, 999999999);

        // Insert Data Booking
        $booking = new Booking;
        $booking->rooms_id = $room->id;
        $booking->user_id = Auth::user()->id;
        $booking->check_in = date('d-m-Y', strtotime($request['check_in']));
        $booking->check_out = date('d-m-Y', strtotime($request['check_out']));
        $booking->person = $request->person;
        $booking->number_of_rooms = $request->number_of_rooms;
        $booking->total_night = $total_nights;
        $booking->actual_price = $room->price;
        $booking->subtotal = $subtotal;
        $booking->discount = $discount;
        $booking->total_price = $total_price;
        $booking->payment_method = 'COD';
        $booking->transaction_id = '';
        $booking->payment_status = 0;
        $booking->name = $request->name;
        $booking->email = $request->email;
        $booking->phone = $request->phone;
        $booking->country = $request->country;
        $booking->state = $request->state;
        $booking->zip_code = $request->zip_code;
        $booking->address = $request->address;
        $booking->code = $code;
        $booking->status = 0;
        $booking->created_at = Carbon::now();
        $booking->save();

        // Room Booked Dates
        $startDate = Carbon::createFromFormat('Y-m-d', $request->check_in);
        $endDate = Carbon::createFromFormat('Y-m-d', $request->check_out);

        // Không lấy ngày checkout - trừ 1 ngày
        $endDate = $endDate->subDay();

        // Tạo danh sách các ngày booking
        $day_period = CarbonPeriod::create($startDate, $endDate);

        foreach ($day_period as $period) {
            $booked_dates = new RoomBookedDate;
            $booked_dates->booking_id = $booking->id;
            $booked_dates->room_id = $room->id;
            $booked_dates->book_date = $period->format('Y-m-d');
            $booked_dates->save();
        }

        // Notification
        $notification = [
            'message' => 'Add Booking Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('booking.list')->with($notification);
    }
}
