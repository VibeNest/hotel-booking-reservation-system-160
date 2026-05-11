<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{
    // Checkout Method
    public function Checkout()
    {
        // Kiểm tra session có data không
        if (Session::has('book_date')) {
            // Nếu có data thì lấy data từ session
            $book_data = Session::get('book_date');
            $room = Room::find($book_data['room_id']);

            // Tính số nights giữa check_in và check_out
            $toDate = Carbon::parse($book_data['check_in']);
            $fromDate = Carbon::parse($book_data['check_out']);
            $nights = $toDate->diffInDays($fromDate);

            return view('frontend.checkout.checkout', compact('book_data', 'room', 'nights'));
        } else {
            // Nếu không có data thì redirect về trang chủ
            $notification = array(
                'message' => 'Something went to wrong!',
                'alert-type' => 'error'
            );
            return redirect('/')->with($notification);
        }
    }

    // Booking Store Method
    public function BookingStore(Request $request, $id)
    {
        // Valtedate data
        $validateData = $request->validate([
            'check_in' => 'required',
            'check_out' => 'required',
            'person' => 'required',
            'number_of_rooms' => 'required',
        ]);

        // Kiểm tra chọn số lượng phòng vượt quá số lượng phòng còn trống
        if ($request->available_room < $request->number_of_rooms) {
            $notification = array(
                'message' => 'Something went to wrong!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        // Lưu dữ liệu vào session
        Session::forget('book_date');
        $data = array();
        $data['room_id'] = $id;
        $data['check_in'] = date('d-m-Y', strtotime($request->check_in));
        $data['check_out'] = date('d-m-Y', strtotime($request->check_out));
        $data['person'] = $request->person;
        $data['number_of_rooms'] = $request->number_of_rooms;
        $data['available_room'] = $request->available_room;
        Session::put('book_date', $data);

        return redirect()->route('checkout');
    }
}
