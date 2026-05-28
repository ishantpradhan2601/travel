<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BoardingPassMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $flight;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, array $flight = null)
    {
        $this->booking = $booking;
        $this->flight = $flight;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your TravelScape Pass / Reservation: ' . $this->booking->booking_reference,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.boarding_pass',
        );
    }
}
