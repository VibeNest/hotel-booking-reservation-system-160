<?php

namespace App\Http\Controllers;

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
        return View("admin.admin_login");
    }
}
