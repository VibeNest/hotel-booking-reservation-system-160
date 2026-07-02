<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingDepositRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking deposit request - HotelHub',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.booking_deposit_request',
            with: [
                'booking' => $this->booking,
                'bankName' => config('booking.bank_name'),
                'bankAccountName' => config('booking.bank_account_name'),
                'bankAccountNumber' => config('booking.bank_account_number'),
                'bankQrPath' => config('booking.bank_qr_path'),
                'bankTransferNote' => config('booking.bank_transfer_note'),
            ],
        );
    }
}
