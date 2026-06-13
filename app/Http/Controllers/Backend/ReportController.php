<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Booking Report Method
    public function BookingReport()
    {
        return view('backend.report.booking_report');
    }

    // Seach By Date Method
    public function SeachByDate(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'))->format('d-m-Y');
        $endDate = Carbon::parse($request->input('end_date'))->format('d-m-Y');

        $bookings = Booking::where('check_in', '>=', $startDate)->where('check_out', '<=', $endDate)->get();

        return view('backend.report.booking_search_date', compact('startDate', 'endDate', 'bookings'));
    }
}
