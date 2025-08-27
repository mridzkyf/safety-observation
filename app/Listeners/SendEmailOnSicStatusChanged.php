<?php

namespace App\Listeners;

use App\Events\SicStatusChanged;
use App\Mail\SoNotificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendEmailOnSicStatusChanged
{
    public function handle(SicStatusChanged $event): void
    {
        $so  = $event->so;
        $old = strtoupper($event->oldStatus ?: 'WAITING');
        $new = strtoupper($event->newStatus);

        // Subject + message dinamis
        $subject = "Status SO #{$so->id} berubah: {$old} ➜ {$new}";
        $msg     = "Status SO Anda berubah dari {$old} menjadi {$new}."
                 . ($new === 'PENDING' && !empty($so->keterangan_pending) ? "\nCatatan: {$so->keterangan_pending}" : '');

        // 1) Kirim ke pelapor (email tersimpan di kolom SO)
        if (!empty($so->email)) {
            Mail::to($so->email)->send(new SoNotificationMail(
                $subject,
                $so,
                [
                    'headline' => 'Status SO Diperbarui',
                    'message'  => $msg,
                    'cta_text' => 'Lihat Detail',
                    'cta_url'  => url("/so/{$so->id}"),
                    // boleh gunakan view default markdown yang kamu punya
                ]
            ));
        }

        // 2) Kirim ke manajemen pelapor (berdasarkan seksi pelapor)
        $roles = ['manager','asistant_manager','supervisor','officer']; // sesuaikan ejaan di DB
        $managerEmails = User::query()
            ->where('nama_seksi', $so->nama_seksi)   // seksi pelapor
            ->whereIn('role', $roles)
            ->pluck('email')->filter()->unique()->all();

        if (!empty($managerEmails)) {
            Mail::to($managerEmails)->send(new SoNotificationMail(
                $subject,
                $so,
                [
                    'headline' => 'Status SO Anggota Seksi Diperbarui',
                    'message'  => "Status SO dari {$so->nama} ({$so->email}) berubah: {$old} ➜ {$new}.",
                    'cta_text' => 'Buka SO',
                    'cta_url'  => url("/approver/so/{$so->id}"),
                ]
            ));
        }
    }
}
