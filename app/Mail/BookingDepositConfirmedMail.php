<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingDepositConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Deposit received - your room is reserved',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.booking_deposit_confirmed',
            with: [
                'booking' => $this->booking,
            ],
        );
    }
}
