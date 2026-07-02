<?php

use App\Mail\BookingDepositConfirmedMail;
use App\Mail\BookingDepositRequestMail;
use App\Mail\BookingPaymentCompletedMail;
use App\Models\Booking;
use App\Observers\Booking\Observers\EmailNotifierObserver;
use Illuminate\Support\Facades\Mail;

it('sends a deposit request email for a pending cod booking', function () {
    Mail::fake();

    $booking = new Booking([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'payment_method' => 'COD',
        'payment_status' => 0,
        'total_price' => 1000,
        'deposit_percentage' => 30,
        'deposit_amount' => 300,
        'remaining_amount' => 700,
    ]);

    (new EmailNotifierObserver)->created($booking);

    Mail::assertSent(BookingDepositRequestMail::class, function (BookingDepositRequestMail $mail) use ($booking) {
        return $mail->booking->email === $booking->email;
    });
});

it('sends a deposit confirmation email when the deposit is confirmed', function () {
    Mail::fake();

    $booking = new Booking([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'payment_method' => 'COD',
        'payment_status' => 2,
        'total_price' => 1000,
        'deposit_percentage' => 30,
        'deposit_amount' => 300,
        'remaining_amount' => 700,
    ]);

    (new EmailNotifierObserver)->depositConfirmed($booking);

    Mail::assertSent(BookingDepositConfirmedMail::class, function (BookingDepositConfirmedMail $mail) use ($booking) {
        return $mail->booking->email === $booking->email;
    });
});

it('sends a payment completed email when the remaining balance is received', function () {
    Mail::fake();

    $booking = new Booking([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'payment_method' => 'COD',
        'payment_status' => 1,
        'total_price' => 1000,
        'deposit_percentage' => 30,
        'deposit_amount' => 300,
        'remaining_amount' => 700,
    ]);

    (new EmailNotifierObserver)->paymentCompleted($booking);

    Mail::assertSent(BookingPaymentCompletedMail::class, function (BookingPaymentCompletedMail $mail) use ($booking) {
        return $mail->booking->email === $booking->email;
    });
});
