<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
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
}
