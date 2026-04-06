<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Home Page 
    public function Index()
    {
        return view("frontend.index");
    }

    // User Profile 
    public function UserProfile()
    {
        // Lấy id người đang đăng nhập (User)
        $id = Auth::user()->id;
        // Lấy thông tin của người đăng nhập (User) thông qua id
        $profileData = User::find($id);
        return view("frontend.dashboard.edit_profile", compact("profileData"));
    }
}
