<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // Home Page 
    public function Index()
    {
        return view("frontend.index");
    }
}
