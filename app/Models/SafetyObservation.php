<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafetyObservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'email',
        'nama_seksi',
        'group',
        'lokasi_kerja',
        'tanggal_pelaporan',
        'lokasi_observasi',
        'judul_temuan',
        'kategori',
        'jenis_temuan',
        'metode',
        'alat_fasilitas',
        'bukti_gambar',
    ];
}
