<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingRoomList;
use App\Models\RoomBookedDate;
use App\Models\RoomNumber;
use App\Services\BookingEventManager;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $previousPaymentStatus = (int) $booking->payment_status;
        $newPaymentStatus = (int) $request->payment_status;

        $booking->payment_status = $request->payment_status;
        $booking->status = $request->status;
        $booking->save();

        if ($previousPaymentStatus !== $newPaymentStatus) {
            if ($newPaymentStatus === 2) {
                BookingEventManager::getInstance()->depositConfirmed($booking);
            }

            if ($newPaymentStatus === 1) {
                BookingEventManager::getInstance()->paymentCompleted($booking);
            }
        }

        // Fire the appropriate event based on status
        if ((int) $request->status === 1) {
            BookingEventManager::getInstance()->approved($booking);
        }

        // Thông báo thành công
        $notification = [
            'message' => 'Updated Status Successfully.',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    // Update Booking Method
    public function UpdateBooking(Request $request, $id)
    {
        // Kiểm tra số lượng phòng vượt quá số lượng phòng có sẵn
        if ($request->available_room < $request->number_of_rooms) {
            $notification = [
                'message' => 'Something want to wrong!',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }

        // Cập nhật thông tin đặt phòng
        $data = Booking::find($id);
        $data->number_of_rooms = $request->number_of_rooms;
        $data->check_in = date('d-m-Y', strtotime($request->check_in));
        $data->check_out = date('d-m-Y', strtotime($request->check_out));
        $data->save();

        // Cập nhật ngày đặt phòng mới
        // Xóa các ngày cũ đã đặt
        RoomBookedDate::where('booking_id', $id)->delete();
        // Xóa các phòng đã gán khi thay đổi ngày đặt phòng
        BookingRoomList::where('booking_id', $id)->delete();

        // Room Booked Dates
        $startDate = date('d-m-Y', strtotime($request->check_in));
        $endDate = date('d-m-Y', strtotime($request->check_out));

        // Không lấy ngày checkout - trừ 1 ngày
        $endDate = Carbon::create($endDate)->subDay();

        // Tạo danh sách các ngày booking
        $day_period = CarbonPeriod::create($startDate, $endDate);

        foreach ($day_period as $period) {
            $booked_dates = new RoomBookedDate;
            $booked_dates->booking_id = $id;
            $booked_dates->room_id = $data->rooms_id;
            $booked_dates->book_date = $period->format('Y-m-d');
            $booked_dates->save();
        }

        $notification = [
            'message' => 'Updated booking successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    // Assign Room Method
    public function AssignRoom($booking_id)
    {
        $booking = Booking::find($booking_id);

        // Lấy danh sách tất cả ngày đã đặt của một booking
        $booking_date_array = RoomBookedDate::where('booking_id', $booking_id)->pluck('book_date')->toArray();

        // Kiểm tra các ngày booking bị trùng nhau => Lấy ra danh sách các booking_id
        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $booking_date_array)
            ->where('room_id', $booking->rooms_id)->distinct()->pluck('booking_id')->toArray();

        // Lấy ra danh sách bookings bị trùng nhau
        $bookings_ids = Booking::whereIn('id', $check_date_booking_ids)->pluck('id')->toArray();

        // Lấy ra danh sách các số phòng đã đặt -> tương ứng các phòng
        $assign_room_ids = BookingRoomList::whereIn('booking_id', $bookings_ids)->pluck('room_number_id')->toArray();

        // Lấy ra danh sách các số phòng chưa được đặt (Chưa được gán)
        $room_numbers = RoomNumber::where('rooms_id', $booking->rooms_id)->whereNotIn('id', $assign_room_ids)
            ->where('status', 'Active')->get();

        return view('backend.booking.assign_room', compact('booking', 'room_numbers'));
    }

    // Assign Room Store Method
    public function AssignRoomStore($booking_id, $room_number_id)
    {
        $booking = Booking::find($booking_id);

        // Đếm số lượng phòng đã gán của đơn đặt phòng đó
        $check_data = BookingRoomList::where('booking_id', $booking_id)->count();

        // Số lượng phòng đã gán không được vượt quá số lượng phòng đã đặt
        if ($check_data < $booking->number_of_rooms) {
            $assign_data = new BookingRoomList;
            $assign_data->booking_id = $booking_id;
            $assign_data->room_id = $booking->rooms_id;
            $assign_data->room_number_id = $room_number_id;
            $assign_data->save();

            $notification = [
                'message' => 'Assign room successfully!',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        } else {
            $notification = [
                'message' => 'Assign room already',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }
    }

    // Assign Room Delete Method
    public function AssignRoomDelete($id)
    {
        $assign_room = BookingRoomList::find($id);
        $assign_room->delete();

        $notification = [
            'message' => 'Deleted assign room successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    // Delete Booking Method
    public function DeleteBooking($id)
    {
        $booking = Booking::find($id);

        // Delete related room booked dates
        RoomBookedDate::where('booking_id', $id)->delete();

        // Delete related booking room list
        BookingRoomList::where('booking_id', $id)->delete();

        // Delete the booking itself
        $booking->delete();

        $notification = [
            'message' => 'Deleted Booking Successfully.',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    // Download Invoice Method
    public function DownloadInvoice($id)
    {
        $editData = Booking::with('room')->find($id);
        $pdf = Pdf::loadView('backend.booking.booking_invoice', compact('editData'))
            ->setPaper('a4')->setOption([
                    'tempDir' => public_path(),
                    'chroot' => public_path(),
                ]);

        return $pdf->download('Booking Invoice.pdf');
    }

    // Mark As Read Method
    public function MarkAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->MarkAsRead();
        }

        return response()->json(['count' => $user->unreadNotifications()->count()]);
    }
}
