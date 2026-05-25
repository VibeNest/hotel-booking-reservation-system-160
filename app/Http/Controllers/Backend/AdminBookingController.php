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
}
