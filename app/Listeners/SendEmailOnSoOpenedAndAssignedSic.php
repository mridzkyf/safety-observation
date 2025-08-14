<?php
namespace App\Listeners;
use App\Events\SoOpenedAndAssignedSic;
use App\Mail\SoAssignedToReporterMail;
use App\Mail\SoAssignedToSicMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendEmailOnSoOpenedAndAssignedSic
{
    public function handle(SoOpenedAndAssignedSic $event): void
    {
        $so = $event->observation;

        // 1) Ke PELAPOR
        if ($so->email) {
            Mail::to($so->email)->send(new SoAssignedToReporterMail($so));
        }

        // 2) Ke SIC (semua user di area yg ditunjuk, role manajemen)
        $roles = ['manager', 'asistant_manager', 'supervisor', 'officer']; // sesuaikan ejaan di DB
        $sicEmails = User::where('area_id', $so->area_id)
            ->whereIn('role', $roles)
            ->pluck('email')->filter()->unique()->all();

        if (!empty($sicEmails)) {
            Mail::to($sicEmails)->send(new SoAssignedToSicMail($so));
        }
    }
}
