<?php

namespace App\Listeners;

use App\Events\SoClosedByManager;
use App\Mail\SoClosedMail;
use Illuminate\Support\Facades\Mail;

class SendEmailOnSoClosedByManager
{
    /**
     * Handle the event.
     */
    public function handle(SoClosedByManager $event): void
    {
        $so = $event->so;

        // Ambil email pelapor langsung dari kolom tabel safety_observations
        $pelaporEmail = $so->email;

        // Kalau email pelapor ada, kirim email
        if ($pelaporEmail) {
            Mail::to($pelaporEmail)->send(new SoClosedByManager($so));
        }
    }
}
