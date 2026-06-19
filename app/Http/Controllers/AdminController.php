<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ImageUploadProxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct(
        protected ImageUploadProxy $imageProxy
    ) {}

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

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Logout successfully!',
            'alert-type' => 'success',
        ];

        return redirect('/admin/login')->with($notification);
    }

    // Admin Login
    public function AdminLogin()
    {
        return view('admin.admin_login');
    }

    // Admin Profile
    public function AdminProfile()
    {
        // Lấy id người đang đăng nhập (Admin)
        $id = Auth::user()->id;
        // Lấy thông tin của người đăng nhập (Admin) thông qua id
        $profileData = User::find($id);

        return view('admin.profile.admin_profile', compact('profileData'));
    }

    // Admin Profile Store Data
    public function AdminProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $oldPhoto = $data->photo;
        // Cập nhật data field của admin
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        // Kiểm tra có photo không -> nếu có thì update photo
        if ($request->file('photo')) {
            if ($oldPhoto) {
                $this->imageProxy->delete('upload/admin_images/' . $oldPhoto);
            }

            $file = $request->file('photo');
            $filename = date('YmdHi') . '-' . $file->getClientOriginalName();
            $this->imageProxy->move($file, 'upload/admin_images', $filename);
            $data->photo = $filename;
        }

        $data->save();

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Updated admin profile successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    // Admin Change Password
    public function AdminChangePassword()
    {
        // Lấy id người đang đăng nhập (Admin)
        $id = Auth::user()->id;
        // Lấy thông tin của người đăng nhập (Admin) thông qua id
        $profileData = User::find($id);

        return view('admin.profile.admin_change_password', compact('profileData'));
    }

    // Admin Password Update
    public function AdminPasswordUpdate(Request $request)
    {
        // Validation
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        // Nếu password không khớp nhau
        if (! Hash::check($request->current_password, Auth::user()->password)) {
            // Hiển thị thông báo toaster
            $notification = [
                'message' => 'Current password does not match!',
                'alert-type' => 'error',
            ];

            return back()->with($notification);
        }

        // Update new password
        $id = Auth::user()->id;
        User::whereId($id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Updated password successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
}
