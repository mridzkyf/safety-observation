<?php

namespace App\Listeners;
use App\Mail\SoNotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailOnSicStatusChanged
{
    public function handle(\App\Events\SicStatusChanged $event): void
    {
        $so = $event->so;
        $statusBaru = strtoupper($event->newStatus);

        $targets = array_filter([
            $so->pelapor->email,
            optional($so->pelapor->manager)->email,
        ]);

        foreach ($targets as $email) {
            Mail::to($email)->send(new SoNotificationMail(
                "Update Status SO: {$statusBaru}",
                $so,
                [
                    'headline' => "Status: {$statusBaru}",
                    'message'  => $event->note ? "Catatan: {$event->note}" : "Status diperbarui menjadi {$statusBaru}.",
                    'cta_text' => 'Lihat Perkembangan',
                    'cta_url'  => url("/so/{$so->id}"),
                ]
            ));
        }
    }
}
