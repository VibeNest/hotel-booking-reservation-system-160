<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\RegistrationOtpNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required'],
        ]);

        $otpCode = (string) random_int(100000, 999999);

        $user = DB::transaction(function () use ($request, $otpCode) {
            return User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => '0',
                'otp_code' => Hash::make($otpCode),
                'otp_expires_at' => now()->addMinutes(10),
            ]);
        });

        $user->notify(new RegistrationOtpNotification($otpCode));

        return redirect()->route('otp.verification.notice', ['email' => $user->email])->with([
            'message' => 'Đăng ký thành công. Vui lòng nhập mã OTP được gửi tới email của bạn.',
            'alert-type' => 'success',
        ]);
    }
}
