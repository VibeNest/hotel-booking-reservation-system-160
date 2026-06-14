<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\SmtpSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class SettingController extends Controller
{
    // Smtp Setting Method
    public function SmtpSetting()
    {
        $smtp = SmtpSetting::find(1);

        return view('backend.setting.smtp_update', compact('smtp'));
    }

    // Smtp Update Method
    public function SmtpUpdate(Request $request)
    {
        $smtp_id = $request->id;

        SmtpSetting::find($smtp_id)->update([
            'mailer' => $request->mailer,
            'host' => $request->host,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
            'from_address' => $request->from_address,
        ]);

        $notification = [
            'message' => 'Updated Smtp Setting Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    // Site Setting Method
    public function SiteSetting()
    {
        $site = SiteSetting::find(1);

        return view('backend.setting.site_update', compact('site'));
    }

    // Site Update Method
    public function SiteUpdate(Request $request)
    {
        $site_id = $request->id;
        $site = SiteSetting::findOrFail($site_id);

        if ($request->file('logo')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($site->logo && file_exists(public_path($site->logo))) {
                unlink(public_path($site->logo));
            }

            // Xử lý upload ảnh mới
            $image = $request->file('logo');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->resize(110, 44)->save(public_path('upload/site/' . $name_gen));
            $save_url = 'upload/site/' . $name_gen;

            // Cập nhật thông tin site vào database khi thay đổi ảnh
            SiteSetting::findOrFail($site_id)->update([
                'phone' => $request->phone,
                'address' => $request->address,
                'email' => $request->email,
                'facebook' => $request->facebook,
                'tiktok' => $request->tiktok,
                'instagram' => $request->instagram,
                'copyright' => $request->copyright,
                'logo' => $save_url,
                'created_at' => Carbon::now(),
            ]);

            // Hiển thị thông báo toaster
            $notification = [
                'message' => 'Updated site with image successfully!',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        } else {
            // Cập nhật thông tin site vào database khi thay đổi ảnh
            SiteSetting::findOrFail($site_id)->update([
                'phone' => $request->phone,
                'address' => $request->address,
                'email' => $request->email,
                'facebook' => $request->facebook,
                'tiktok' => $request->tiktok,
                'instagram' => $request->instagram,
                'copyright' => $request->copyright,
                'created_at' => Carbon::now(),
            ]);

            // Hiển thị thông báo toaster
            $notification = [
                'message' => 'Updated site without image successfully!',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        }
    }
}
