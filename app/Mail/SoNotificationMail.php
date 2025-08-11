<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SoNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $subjectText,
        public SafetyObservation $so,
        public array $context = [] // headline, message, cta_text, cta_url
    ) {}

    public function build()
    {
        return $this->subject($this->subjectText)
            ->markdown('emails.so_notification')
            ->with([
                'so' => $this->so,
                'x'  => $this->context,
            ]);
    }
}
