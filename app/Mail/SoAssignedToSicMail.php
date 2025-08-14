<?php

namespace App\Mail;

use App\Models\SafetyObservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SoAssignedToSicMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public SafetyObservation $so) {}

    public function build()
    {
        return $this->subject("Tugas SO Baru: #{$this->so->id}")
            ->view('emails.so_assigned_sic')
            ->with(['so' => $this->so]);
    }
}
