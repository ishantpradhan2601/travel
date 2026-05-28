<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class AllPassesMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bookings;
    public $recipientName;

    /**
     * Create a new message instance.
     */
    public function __construct(Collection $bookings, string $recipientName)
    {
        $this->bookings = $bookings;
        $this->recipientName = $recipientName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'All Your TravelScape Boarding Passes & Stays',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.all_passes',
        );
    }
}
