<?php

namespace App\Listeners;

use App\Events\SicStatusChanged;
use App\Mail\SicStatusChangedReporterMail;
use App\Mail\SicStatusChangedManagementMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendEmailOnSicStatusChanged
{
    public function handle(SicStatusChanged $event): void
    {
        $so        = $event->so;
        $oldStatus = $event->oldStatus;
        $newStatus = $event->newStatus;
        $note      = $event->note;

        // 1) Pelapor
        if (!empty($so->email)) {
            Mail::to($so->email)->send(
                new SicStatusChangedReporterMail($so, $oldStatus, $newStatus, $note, $so->keterangan_status)
            );
        }

        // 2) Manajemen pelapor (sesuaikan ejaan role dg DB)
        $roles = ['manager', 'asisten_manager', 'supervisor', 'officer'];
        $managerEmails = User::where('nama_seksi', $so->nama_seksi)
            ->whereIn('role', $roles)
            ->pluck('email')->filter()->unique()->all();

        if ($managerEmails) {
            Mail::to($managerEmails)->send(
                new SicStatusChangedManagementMail($so, $oldStatus, $newStatus, $note, $so->keterangan_status)
            );
        }
    }
}
