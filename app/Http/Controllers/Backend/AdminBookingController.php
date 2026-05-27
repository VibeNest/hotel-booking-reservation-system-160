<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\RoomBookedDate;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    // Booking List Method
    public function BookingList()
    {
        $allData = Booking::orderBy('id', 'desc')->get();
        return view('backend.booking.booking_list', compact('allData'));
    }

    // Edit Booking Method
    public function EditBooking($id)
    {
        $editData = Booking::with('room')->find($id);
        return view('backend.booking.edit_booking', compact('editData'));
    }

    // Update Booking Status Method
    public function UpdateBookingStatus(Request $request, $id)
    {
        $booking = Booking::find($id);
        $booking->payment_status = $request->payment_status;
        $booking->status = $request->status;
        $booking->save();

        // Thông báo thành công
        $notification = array(
            'message' => 'Updated Information Successfully.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    // Update Booking Method
    public function UpdateBooking(Request $request, $id)
    {
        // Kiểm tra số lượng phòng vượt quá số lượng phòng có sẵn
        if ($request->available_room < $request->number_of_rooms) {
            $notification = array(
                'message' => 'Something want to wrong!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        // Cập nhật thông tin đặt phòng
        $data = Booking::find($id);
        $data->number_of_rooms = $request->number_of_rooms;
        $data->check_in = date('d-m-Y', strtotime($request->check_in));
        $data->check_out = date('d-m-Y', strtotime($request->check_out));
        $data->save();

        // Cập nhật ngày đặt phòng mới
        // Xóa các ngày đã đặt cũ
        RoomBookedDate::where('booking_id', $id)->delete(); 

        // Room Booked Dates
        $startDate = date('d-m-Y', strtotime($request->check_in));
        $endDate = date('d-m-Y', strtotime($request->check_out));

        // Không lấy ngày checkout - trừ 1 ngày
        $endDate = Carbon::create($endDate)->subDay();

        // Tạo danh sách các ngày booking
        $day_period = CarbonPeriod::create($startDate, $endDate);

        foreach ($day_period as $period) {
            $booked_dates = new RoomBookedDate();
            $booked_dates->booking_id = $id;
            $booked_dates->room_id = $data->rooms_id;
            $booked_dates->book_date = $period->format('Y-m-d');
            $booked_dates->save();
        }

        $notification = array(
                'message' => 'Updated booking successfully!',
                'alert-type' => 'success'
            );
            
        return redirect()->back()->with($notification);
    }
}
