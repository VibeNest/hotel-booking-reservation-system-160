<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Contact Us Method
    public function ContactUs()
    {
        return view('frontend.contact.contact_us');
    }
}
