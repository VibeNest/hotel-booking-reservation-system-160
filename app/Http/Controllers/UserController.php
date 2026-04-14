<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Team;

class UserController extends Controller
{
    // Home Page 
    public function Index()
    {
        $team = Team::latest()->get();
        return view('frontend.index', compact('team'));

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

    // User Profile Store Data 
    public function UserProfileStore(Request $request)
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
            if ($oldPhoto && file_exists(public_path('upload/user_images/' . $oldPhoto))) {
                unlink(public_path('upload/user_images/' . $oldPhoto));
            }

            $file = $request->file('photo');
            $filename = date('YmdHi') . '-' . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $data->photo = $filename;
        }

        $data->save();

        // Hiển thị thông báo toaster
        $notification = array(
            'message' => 'Updated user profile successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    // User Logout
    public function UserLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Hiển thị thông báo toaster
        $notification = array(
            'message' => 'Logout successfully!',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    }

    // User Change Password
    public function UserChangePassword()
    {
        return view("frontend.dashboard.user_change_password");
    }

    // User Password Update
    public function UserPasswordUpdate(Request $request)
    {
        // Validation
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        // Nếu password không khớp nhau
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            // Hiển thị thông báo toaster
            $notification = array(
                'message' => 'Current password does not match!',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        }

        // Update new password
        $id = Auth::user()->id;
        User::whereId($id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Hiển thị thông báo toaster
        $notification = array(
            'message' => 'Updated password successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}