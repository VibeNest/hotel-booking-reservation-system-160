<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SmtpSetting;
use Illuminate\Http\Request;

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
}
