<?php

namespace App\Exports;

use App\Models\SafetyObservation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class SafetyObservationExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;
    protected $mode;
    protected $seksi;
    protected $modeTerlapor; // TRUE jika export data berdasarkan area_id (terlapor)

    public function __construct($startDate = null, $endDate = null, $mode = 'all', $seksi = null, $modeTerlapor = false)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->mode = $mode;
        $this->seksi = $seksi;
        $this->modeTerlapor = $modeTerlapor;
    }

    public function collection()
    {
        $query = SafetyObservation::query();

        if ($this->modeTerlapor) {
            // 🔄 Join ke tabel areas karena ingin data terlapor (berdasarkan area_id)
            $query->select(
                    'safety_observations.created_at',
                    'safety_observations.nama',
                    'safety_observations.email',
                    'safety_observations.nama_seksi',
                    'safety_observations.status',
                    'safety_observations.group',
                    'safety_observations.lokasi_kerja',
                    'safety_observations.lokasi_observasi',
                    'safety_observations.judul_temuan',
                    'safety_observations.kategori',
                    'safety_observations.situasi',
                    'safety_observations.tindakan',
                    'areas.name',
                    'areas.name as seksi_tujuan'
                )
                ->join('areas', 'safety_observations.area_id', '=', 'areas.id')
                ->whereNotNull('safety_observations.area_id');

            if ($this->seksi) {
                $query->where('areas.name', $this->seksi);
            }
        } else {
            // 🔍 Data default (pelapor)
            $query->select(
                'created_at',
                'nama',
                'email',
                'nama_seksi',
                'status',
                'group',
                'lokasi_kerja',
                'lokasi_observasi',
                'judul_temuan',
                'kategori',
                'situasi',
                'tindakan'
            );

            if ($this->seksi && strtoupper($this->seksi) !== 'SHE') {
                $query->where('nama_seksi', $this->seksi);
            }
        }

        // 📅 Filter tanggal
        if ($this->mode === 'single') {
            $query->whereDate('safety_observations.created_at', $this->startDate);
        } elseif ($this->mode === 'range') {
            $query->whereBetween('safety_observations.created_at', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        $default = ['Tanggal', 'Nama', 'Email', 'Nama Seksi', 'Status SO', 'Group', 'Lokasi Kerja', 'Lokasi Observasi', 'Judul Temuan', 'Kategori', 'Situasi', 'Tindakan'];

        if ($this->modeTerlapor) {
            return array_merge($default, ['Area Tujuan', 'Seksi Tujuan']);
        }

        return $default;
    }
}
