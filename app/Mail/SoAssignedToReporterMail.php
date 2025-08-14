<?php

namespace App\Mail;

use App\Models\SafetyObservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SoAssignedToReporterMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public SafetyObservation $so) {}

    public function build()
    {
        return $this->subject('SO Anda telah ditunjuk ke SIC Area')
            ->view('emails.so_assigned_pelapor')
            ->with(['so' => $this->so]);
    }
}
