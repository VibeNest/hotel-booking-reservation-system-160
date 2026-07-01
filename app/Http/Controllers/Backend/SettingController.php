<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\SmtpSetting;
use App\Services\ImageUploadProxy;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        protected ImageUploadProxy $imageProxy
    ) {
    }

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
            'scheme' => $request->filled('scheme') ? strtolower(trim($request->scheme)) : null,
            'host' => $request->host,
            'port' => $request->port,
            'username' => $request->username,
            'password' => preg_replace('/\s+/', '', (string) $request->password),
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
            $this->imageProxy->delete($site->logo);

            $image = $request->file('logo');
            $save_url = 'upload/site/' . $this->imageProxy->upload($image, 'upload/site', 110, 44);

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
