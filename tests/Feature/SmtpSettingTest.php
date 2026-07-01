<?php

use App\Models\SmtpSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

use function Pest\Laravel\withoutMiddleware;

uses(RefreshDatabase::class);

beforeEach(function () {
    withoutMiddleware();
});

it('updates smtp scheme and connection details from the admin form', function () {
    $smtp = SmtpSetting::create([
        'mailer' => 'smtp',
        'scheme' => 'tls',
        'host' => 'smtp.gmail.com',
        'port' => '587',
        'username' => 'old@example.com',
        'password' => 'secret',
        'from_address' => 'old@example.com',
    ]);

    $response = $this->post(route('smtp.update'), [
        'id' => $smtp->id,
        'mailer' => 'smtp',
        'scheme' => 'TLS',
        'host' => 'smtp.gmail.com',
        'port' => '587',
        'username' => 'yourname@gmail.com',
        'password' => 'fgnu ptlo rpfp mmf',
        'from_address' => 'yourname@gmail.com',
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('smtp_settings', [
        'id' => $smtp->id,
        'scheme' => 'tls',
        'host' => 'smtp.gmail.com',
        'port' => '587',
        'username' => 'yourname@gmail.com',
        'from_address' => 'yourname@gmail.com',
    ]);

    expect(SmtpSetting::findOrFail($smtp->id)->password)->toBe('fgnuptlorpfpmmf');
});

it('normalizes tls scheme into a supported smtp mailer configuration', function () {
    $smtp = SmtpSetting::create([
        'mailer' => 'smtp',
        'scheme' => 'tls',
        'host' => 'smtp.gmail.com',
        'port' => '587',
        'username' => 'yourname@gmail.com',
        'password' => 'fgnuptlorfpfpmmf',
        'from_address' => 'yourname@gmail.com',
    ]);

    expect($smtp->mailerScheme())->toBe('smtp');
    expect($smtp->mailerEncryption())->toBe('tls');
});

it('can send an otp email through the smtp mailer', function () {
    Mail::fake();

    $smtp = SmtpSetting::create([
        'mailer' => 'smtp',
        'scheme' => 'tls',
        'host' => 'smtp.gmail.com',
        'port' => '587',
        'username' => 'yourname@gmail.com',
        'password' => 'fgnuptlorpfpmmf',
        'from_address' => 'yourname@gmail.com',
    ]);

    $this->post(route('register'), [
        'name' => 'Nguyen Van A',
        'phone' => '0900000001',
        'address' => 'Ha Noi',
        'email' => 'customer@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    Mail::assertSent(\App\Mail\RegistrationOtpMail::class, function (\App\Mail\RegistrationOtpMail $mail) {
        return $mail->hasTo('customer@example.com');
    });
});
