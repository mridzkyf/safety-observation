<?php

namespace App\Http\Controllers;

use App\Models\SafetyObservation;

use Illuminate\Http\Request;

class SafetyObservationController extends Controller
{
    //
    public function create()
    {
        $daftarSeksi = [
            'ADM',
            'Account & Tax',
            'CA',
            'EI',
            'ENG PET',
            'FT',
            'IFB',
            'IFC',
            'IT',
            'KTF',
            'LOG',
            'MC',
            'MFG PET',
            'MKT PF',
            'Material Purchasing',
            'Service Purchasing & Vendor Management',
            'QA & CTS KTF - PF',
            'QC KTF-PF',
            'QQC PET',
            'SHE',
            'TC'
        ];
        return view('safety_observation.form', compact('daftarSeksi'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'nama_seksi' => 'required',
            'group' => 'required',
            'lokasi_kerja' => 'required',
            'tanggal_pelaporan' => 'required|date',
            'lokasi_observasi' => 'required',
            'judul_temuan' => 'required',
            'kategori' => 'required',
            'jenis_temuan' => 'required',
            'metode' => 'required',
            'alat_fasilitas' => 'required',
            'bukti_gambar' => 'required|nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('bukti_gambar')) {
            $data['bukti_gambar'] = $request->file('bukti_gambar')->store('bukti', 'public');
        }

        SafetyObservation::create($data);
        return redirect()->back()->with('success', 'Form berhasil dikirim!');
    }
}
