<?php

namespace App\Mail;

use App\Models\SafetyObservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SicStatusChangedReporterMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public SafetyObservation $so,
        public string $oldStatus,
        public string $newStatus,
        public ?string $note = null,
        public ?string $keterangan_status = null
    ) {}

    public function build()
    {
        return $this->subject("Status SO #{$this->so->id} diperbarui: " . strtoupper($this->oldStatus) . " ➜ " . strtoupper($this->newStatus))
            ->view('emails.sic_status_changed_pelapor')
            ->with([
                'so'        => $this->so,
                'oldStatus' => strtoupper($this->oldStatus ?: 'WAITING'),
                'newStatus' => strtoupper($this->newStatus),
                'note'      => $this->note,
                'keterangan_status'=> $this->keterangan_status,
            ]);
    }
}