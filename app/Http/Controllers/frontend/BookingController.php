<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Booking;
use App\Models\RoomBookedDate;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

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

    // Place Order Method
    public function PlaceOrder()
    {
        return view('frontend.checkout.place_order');
    }

    // Checkout Store Method
    public function CheckoutStore(Request $request)
    {
        // Check session tồn tại
        if (!Session::has('book_date')) {
            return redirect()
                ->route('checkout')
                ->with('error', 'Session expired');
        }
    
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'payment_method' => 'required',
        ]);

        // Lấy dữ liệu từ session
        $book_data = Session::get('book_date');

        // Lấy room
        $room = Room::find($book_data['room_id']);

        // Tính số đêm
        $toDate = Carbon::parse($book_data['check_in']);
        $fromDate = Carbon::parse($book_data['check_out']);

        $total_nights = $toDate->diffInDays($fromDate);

        // Tính tiền
        $subtotal = $room->price * $total_nights * $book_data['number_of_rooms'];

        // Discount
        $discount = ($room->discount / 100) * $subtotal;

        // Total Price
        $total_price = $subtotal - $discount;

        // Generate booking code 9 số
        $code = rand(100000000, 999999999);

        if ($request->payment_method == 'paypal') {

            Session::put('checkout_data', [

                'name' => $request->name,
                'email' => $request->email,
                'country' => $request->country,
                'phone' => $request->phone,
                'address' => $request->address,
                'state' => $request->state,
                'zip_code' => $request->zip_code,

                'subtotal' => $subtotal,
                'discount' => $discount,
                'total_price' => $total_price,
                'total_nights' => $total_nights,

            ]);

            return redirect()
                ->route('paypal.payment');
        }

        // Insert Data Booking
        $booking = new Booking();

        $booking->rooms_id = $room->id;
        $booking->user_id = Auth::id();

        $booking->check_in = date('d-m-Y', strtotime($book_data['check_in']));
        $booking->check_out = date('d-m-Y', strtotime($book_data['check_out']));

        $booking->person = $book_data['person'];
        $booking->number_of_rooms = $book_data['number_of_rooms'];

        $booking->total_night = $total_nights;

        $booking->actual_price = $room->price;

        $booking->subtotal = $subtotal;
        $booking->discount = $discount;
        $booking->total_price = $total_price;

        $booking->payment_method = $request->payment_method;
        $booking->transaction_id = "";
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
        $startDate = Carbon::createFromFormat('d-m-Y', $book_data['check_in']);
        $endDate = Carbon::createFromFormat('d-m-Y', $book_data['check_out']);

        // Không lấy ngày checkout - trừ 1 ngày
        $endDate = $endDate->subDay();

        // Tạo danh sách các ngày booking
        $day_period = CarbonPeriod::create($startDate, $endDate);

        foreach ($day_period as $period) {
            $booked_dates = new RoomBookedDate();
            $booked_dates->booking_id = $booking->id;
            $booked_dates->room_id = $room->id;
            $booked_dates->book_date = $period->format('Y-m-d');
            $booked_dates->save();
        }

        // Clear Session
        Session::forget('book_date');

        // Notification
        $notification = array(
            'message' => 'Add Booking Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('place.order')->with($notification);
    }

    // Paypal Payment
    public function PaypalPayment()
    {
        $checkout = Session::get('checkout_data');

        if (!$checkout) {
            return redirect()
                ->route('checkout')
                ->with('error', 'Session expired');
        }

        if (
            !isset($checkout['total_price']) ||
            $checkout['total_price'] <= 0
        ) {
            return redirect()
                ->route('checkout')
                ->with('error', 'Invalid payment amount');
        }

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);
        $response = $provider->createOrder([
                "intent" => "CAPTURE",

                "application_context" => [
                    "return_url" => route('paypal.success'),
                    "cancel_url" => route('paypal.cancel'),
                ],

                "purchase_units" => [
                    [
                        "amount" => [

                            "currency_code" => "USD",

                            "value" => number_format(
                                $checkout['total_price'],
                                2,
                                '.',
                                ''
                            )
                        ]
                    ]
                ]
            ]);

        if (!empty($response['id']) && isset($response['links'])) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()
                        ->away($link['href']);
                }
            }
        }

        return redirect()->route('checkout')
            ->with('error', 'Paypal payment failed');
    }

    // Paypal Success

    public function PaypalSuccess(Request $request)
    {
        if (!Session::has('checkout_data') || !Session::has('book_date'))
        {
            return redirect()
                ->route('checkout')
                ->with('error', 'Session expired');
        }

        if (!$request->token || empty($request->token)) {
            return redirect()
                ->route('checkout')
                ->with('error', 'Invalid PayPal token');
        }

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);
        $response = $provider->capturePaymentOrder($request->token);

        $existingBooking = Booking::where(
            'transaction_id',
            $response['id']
        )->first();

        if ($existingBooking) {
            return redirect()
                ->route('place.order')
                ->with('success', 'Payment already processed');
        }

        if (isset($response['status']) && $response['status'] == 'COMPLETED' && isset($response['id'])) {

            $book_data = Session::get('book_date');
            $checkout = Session::get('checkout_data');
            $room = Room::find($book_data['room_id']);
            if (!$room) {
                Session::forget('book_date');
                Session::forget('checkout_data');
                return redirect('/')
                    ->with('error', 'Room not found');
            }
            $booking = new Booking();

            $booking->rooms_id = $room->id;
            $booking->user_id = Auth::id();
            $booking->check_in = $book_data['check_in'];
            $booking->check_out = $book_data['check_out'];
            $booking->person = $book_data['person'];
            $booking->number_of_rooms = $book_data['number_of_rooms'];
            $booking->total_night = $checkout['total_nights'];
            $booking->actual_price = $room->price;
            $booking->subtotal = $checkout['subtotal'];
            $booking->discount = $checkout['discount'];
            $booking->total_price = $checkout['total_price'];
            $booking->payment_method = "paypal";

            $booking->transaction_id = $response['id'];

            $booking->payment_status = 1;

            $booking->name = $checkout['name'];
            $booking->email = $checkout['email'];
            $booking->phone = $checkout['phone'];
            $booking->country = $checkout['country'];
            $booking->state = $checkout['state'];
            $booking->zip_code = $checkout['zip_code'];
            $booking->address = $checkout['address'];

            $booking->code = rand(100000000, 999999999);

            $booking->status = 0;

            $booking->created_at = Carbon::now();

            $booking->save();

            // Room booked dates

            $startDate =
                Carbon::createFromFormat(
                    'd-m-Y',
                    $book_data['check_in']
                );

            $endDate =
                Carbon::createFromFormat(
                    'd-m-Y',
                    $book_data['check_out']
                );

            $endDate = $endDate->subDay();

            $day_period =
                CarbonPeriod::create(
                    $startDate,
                    $endDate
                );

            foreach ($day_period as $period) {

                $booked_dates = new RoomBookedDate();

                $booked_dates->booking_id = $booking->id;

                $booked_dates->room_id = $room->id;

                $booked_dates->book_date = $period->format('Y-m-d');

                $booked_dates->save();
            }

            Session::forget('book_date');

            Session::forget('checkout_data');

            return redirect()
                ->route('place.order')
                ->with('success', 'Paypal Payment Successfully');
        }

        return redirect()
            ->route('checkout')
            ->with('error', 'Payment Failed');
    }

    // Paypal Cancel

    public function PaypalCancel()
    {
        Session::forget('checkout_data');
        return redirect()
            ->route('checkout')
            ->with('error', 'Payment Cancelled');
    }
}

// test Paypal tk personal
// email: personal2026@personal.example.com
// password: 12345678

// paypal tk business
// business2026@business.example.com
// 12345678
