<?php

namespace App\Listeners;

use App\Events\SoSubmitted;
use App\Mail\SoNotificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailOnSoSubmitted
{
    public function handle(SoSubmitted $event): void
    {
        $so = $event->so;                    // SafetyObservation
        $seksi = $so->nama_seksi;            // patokannya seksi dari SO

        // Daftar role manajemen yang harus menerima email
        $targetRoles = ['manager', 'asistant_manager', 'supervisor', 'officer'];

        // Ambil semua email user sesuai seksi & role
        $emails = User::query()
            ->whereIn('role', $targetRoles)
            ->when($seksi, fn ($q) => $q->where('nama_seksi', $seksi))
            ->pluck('email')
            ->filter()   // buang null/kosong
            ->unique()
            ->values()
            ->all();

        // Fallback untuk testing Mailtrap (opsional)
        if (empty($emails) && ($fallback = env('MAILTRAP_TEST_TO'))) {
            $emails = [$fallback];
            Log::warning("Tidak ditemukan penerima untuk seksi '{$seksi}'. Pakai MAILTRAP_TEST_TO: {$fallback}");
        }

        if (empty($emails)) {
            Log::warning("Notif submit SO {$so->id} tidak terkirim: daftar email kosong.");
            return;
        }

        Mail::to($emails)->send(new SoNotificationMail(
            "SO Baru dari {$so->nama} diterima",
            $so,
            [
                'headline' => 'Laporan SO Baru Masuk',
                'message'  => "Ada Safety Observation baru dari {$so->nama} di seksi {$seksi}. Tolong segera di Proses",
                'cta_text' => 'Buka SO',
                'cta_url'  => url("/approver/so/{$so->id}"),
            ]
        ));
    }
}
