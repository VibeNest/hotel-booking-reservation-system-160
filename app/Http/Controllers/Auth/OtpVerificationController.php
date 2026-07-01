<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\RegistrationOtpNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    public function create(Request $request): RedirectResponse|View
    {
        $user = $this->pendingUser($request);

        if (!$user) {
            return redirect()->route('register');
        }

        return view('auth.otp-verification', [
            'user' => $user,
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'otp' => ['required', 'digits:6'],
        ]);

        $user = $this->pendingUser($request);

        if (!$user) {
            return redirect()->route('register');
        }

        if ($user->otp_expires_at && $user->otp_expires_at->isPast()) {
            throw ValidationException::withMessages([
                'otp' => 'Mã OTP đã hết hạn. Vui lòng gửi lại mã mới.',
            ]);
        }

        if (!$user->otp_code || !Hash::check($request->string('otp'), $user->otp_code)) {
            throw ValidationException::withMessages([
                'otp' => 'Mã OTP không đúng. Vui lòng kiểm tra lại email.',
            ]);
        }

        $user->forceFill([
            'status' => '1',
            'email_verified_at' => now(),
            'otp_code' => null,
            'otp_expires_at' => null,
        ])->save();

        return redirect()->route('login')->with([
            'message' => 'Xác thực OTP thành công. Bạn có thể đăng nhập ngay bây giờ.',
            'alert-type' => 'success',
        ]);
    }

    public function resend(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $user = $this->pendingUser($request);

        if (!$user) {
            return redirect()->route('register');
        }

        $otpCode = $this->generateOtpCode();

        $user->forceFill([
            'otp_code' => Hash::make($otpCode),
            'otp_expires_at' => now()->addMinutes(10),
        ])->save();

        $user->notify(new RegistrationOtpNotification($otpCode));

        return redirect()->route('otp.verification.notice', ['email' => $user->email])->with([
            'message' => 'Đã gửi lại mã OTP tới email của bạn.',
            'alert-type' => 'success',
        ]);
    }

    private function pendingUser(Request $request): ?User
    {
        $email = $request->input('email', $request->query('email'));

        if (!$email) {
            return null;
        }

        return User::where('email', $email)->first();
    }

    private function generateOtpCode(): string
    {
        return (string) random_int(100000, 999999);
    }
}
