<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Contact Us Method
    public function ContactUs()
    {
        return view('frontend.contact.contact_us');
    }

    // Store Contact Method
    public function StoreContact(Request $request)
    {
        Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Send your message successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
}
