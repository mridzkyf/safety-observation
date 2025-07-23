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
        'sub_metode',
        'sub_alat',
        'sub_apd',
        'sub_5s',
        'sub_posisi',
        'situasi',
        'tindakan',
        'bukti_gambar'
    ];

    public function sic()
    {
        return $this->belongsTo(User::class, 'sic_id');
    }
    public function area()
{
    return $this->belongsTo(Area::class);
}
}
