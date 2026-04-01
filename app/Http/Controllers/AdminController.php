<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use View;

class AdminController extends Controller
{
    // Admin Dashboard
    public function AdminDashboard()
    {
        return view('admin.index');
    }

    // Admin Logout
    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    // Admin Login
    public function AdminLogin()
    {
        return view("admin.admin_login");
    }

    // Admin Profile 
    public function AdminProfile()
    {
        // Lấy id người đang đăng nhập (Admin)
        $id = Auth::user()->id;
        // Lấy thông tin của người đăng nhập (Admin) thông qua id
        $profileData = User::find($id);
        return view("admin.profile.admin_profile", compact("profileData"));
    }
}
