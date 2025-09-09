<?php

namespace App\Mail;

use App\Models\SafetyObservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SicStatusChangedManagementMail extends Mailable implements ShouldQueue
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
        return $this->subject("Status SO Bawahan #{$this->so->id}: " . strtoupper($this->oldStatus) . " ➜ " . strtoupper($this->newStatus))
            ->view('emails.sic_status_changed_management')
            ->with([
                'so'        => $this->so,
                'oldStatus' => strtoupper($this->oldStatus ?: 'WAITING'),
                'newStatus' => strtoupper($this->newStatus),
                'note'      => $this->note,
                'keterangan_status'=> $this->keterangan_status,
            ]);
    }
}
