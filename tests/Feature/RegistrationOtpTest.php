<?php

use App\Models\User;
use App\Mail\RegistrationOtpMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\withoutMiddleware;

uses(RefreshDatabase::class);

beforeEach(function () {
    withoutMiddleware();
});

it('sends otp and keeps the account inactive after registration', function () {
    Mail::fake();

    $response = $this->post(route('register'), [
        'name' => 'Nguyen Van A',
        'phone' => '0900000001',
        'address' => 'Ha Noi',
        'email' => 'customer@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertRedirect(route('otp.verification.notice', ['email' => 'customer@example.com']));

    $user = User::where('email', 'customer@example.com')->firstOrFail();

    expect($user->status)->toBe('0');
    expect($user->otp_code)->not->toBeNull();
    expect($user->otp_expires_at)->not->toBeNull();

    Mail::assertSent(RegistrationOtpMail::class, function (RegistrationOtpMail $mail) use ($user): bool {
        return $mail->hasTo($user->email)
            && $mail->name === $user->name
            && Hash::check($mail->otpCode, $user->otp_code);
    });
});

it('activates the account when the correct otp is submitted', function () {
    $user = User::factory()->create([
        'status' => '0',
        'otp_code' => Hash::make('123456'),
        'otp_expires_at' => now()->addMinutes(10),
    ]);

    $this->post(route('otp.verification.verify'), [
        'email' => $user->email,
        'otp' => '123456',
    ])->assertRedirect(route('login'));

    $user->refresh();

    expect($user->status)->toBe('1');
    expect($user->otp_code)->toBeNull();
    expect($user->otp_expires_at)->toBeNull();
});

it('rejects login for accounts that are not otp verified', function () {
    $user = User::factory()->create([
        'status' => '0',
        'password' => Hash::make('Password123!'),
    ]);

    $response = $this->from(route('login'))->post(route('login'), [
        'login' => $user->email,
        'password' => 'Password123!',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors('login');
});
