<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    // Admin Profile Store Data 
    public function AdminProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $oldPhoto = $data->photo;
        // Cập nhật data field của user
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        // Kiểm tra có photo không -> nếu có thì update photo
        if ($request->file('photo')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($oldPhoto && file_exists(public_path('upload/admin_images/' . $oldPhoto))) {
                unlink(public_path('upload/admin_images/' . $oldPhoto));
            }

            $file = $request->file('photo');
            $filename = date('YmdHi') . '-' . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data->photo = $filename;
        }

        $data->save();

        // Hiển thị thông báo toaster
        $notification = array(
            'message' => 'Updated Admin Profile Successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
