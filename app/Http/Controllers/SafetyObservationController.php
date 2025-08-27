<?php

namespace App\Http\Controllers;

use App\Models\SafetyObservation;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\SoSubmitted; // <-- import event

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
        $user = auth()->user();
        return view('safety_observation.form', compact('daftarSeksi','user'));
    }
public function laporanSaya(Request $request)
{
    $user = Auth::user();

    //Queery untuk menampilkan satu seksi 

    $areaId = auth()->user()->area_id;

    // Query dasar berdasarkan email user
    $ongoingQuery = SafetyObservation::where('email', $user->email)
        ->whereIn('status', ['open', 'on_progress', 'pending', 'waiting']);

    $closedQuery = SafetyObservation::where('email', $user->email)
        ->where('status', 'closed');

    // Query data ke area user (laporan ke seksi dia)
    $terlaporQuery = SafetyObservation::where('area_id', $areaId)->where('email', '!=', $user->email);

    // Filtering ongoing
    if ($request->filled('tanggal_pelaporan_ongoing')) {
        $ongoingQuery->whereDate('tanggal_pelaporan', $request->tanggal_pelaporan_ongoing);
    }

    if ($request->filled('judul_temuan_ongoing')) {
        $ongoingQuery->where('judul_temuan', 'like', '%' . $request->judul_temuan_ongoing . '%');
    }

    if ($request->filled('kategori_ongoing')) {
        $ongoingQuery->where('kategori', 'like', '%' . $request->kategori_ongoing . '%');
    }

    if ($request->filled('status_ongoing')) {
        // Jika user filter status khusus (misal hanya ingin lihat "open")
        // Maka override filter bawaan
        $ongoingQuery->where('status', $request->status_ongoing);
    }

    // Filltering Closed
    if ($request->filled('tanggal_pelaporan_closed')) {
        $closedQuery->whereDate('tanggal_pelaporan', $request->tanggal_pelaporan_closed);
    }
    if ($request->filled('judul_temuan_closed')) {
        $closedQuery->where('judul_temuan', 'like', '%' . $request->judul_temuan_closed . '%');
    }
    if ($request->filled('kategori_closed')) {
        $closedQuery->where('kategori', 'like', '%' . $request->kategori_closed . '%');
    }


    // Eksekusi paginasi
    $ongoing = $ongoingQuery->latest()->paginate(5,['*'],'on_progress')->withQueryString();
    $closed = $closedQuery->latest()->paginate(5,['*'],'history')->withQueryString();
    $terlapor = $terlaporQuery->latest()->paginate(5,['*'],'history_section')->withQueryString();

    return view('user.laporan', compact('ongoing', 'closed','terlapor'));
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
            'sub_metode' => 'nullable',
            'sub_alat' => 'nullable',
            'sub_apd' => 'nullable',
            'sub_5s' => 'nullable',
            'sub_posisi' => 'nullable',
            'situasi' => 'required',
            'tindakan' => 'required',
            'bukti_gambar' => 'required_unless:kategori,Unsafe Act|nullable|image|mimes:jpeg,png,jpg|max:20480',
        ]);
    $jenis = $request->jenis_temuan;
    $subFieldMap = [
        'Metode' => 'sub_metode',
        'Alat/Fasilitas' => 'sub_alat',
        'APD' => 'sub_apd',
        '5S & G7' => 'sub_5s',
        'Posisi Kerja' => 'sub_posisi',
    ];

    $subFieldName = $subFieldMap[$jenis] ?? null;

    if ($subFieldName && !$request->filled($subFieldName)) {
        return back()
            ->withInput()
            ->withErrors([$subFieldName => 'Bagian ini wajib diisi sesuai jenis temuan.']);
    }

    if ($request->hasFile('bukti_gambar')) {
        $file = $request->file('bukti_gambar');

        // Cek ukuran file dalam bytes (10MB = 10 * 1024 * 1024)
        if ($file->getSize() > 10 * 1024 * 1024) {
            // Kompres gambar
            $image = Image::make($file)->encode('jpg', 70); // kualitas 70%

            // Generate nama file unik
            $filename = uniqid() . '.jpg';

            // Simpan ke storage/app/public/bukti
            Storage::disk('public')->put('bukti/' . $filename, $image);

            // Simpan nama file ke DB
            $data['bukti_gambar'] = 'bukti/' . $filename;
        } else {
            // Simpan tanpa kompresi
            $data['bukti_gambar'] = $file->store('bukti', 'public');
        }
    }

            // Tambahkan status default untuk notifikasi
        $data['status'] = 'open';

        // SafetyObservation::create($data);
         // Simpan SO
        $so = SafetyObservation::create($data);
        // === INI KUNCI LANGKAH 5: panggil event ===
        event(new SoSubmitted($so));
        return redirect()->back()->with('success', 'Form berhasil dikirim!');
    }


    public function show($id)
{
    $item = SafetyObservation::findOrFail($id);
    return view('user.userdetail', compact('item'));
}

public function assignArea(Request $request, $id)
{
    $request->validate([
        'area_id' => 'required|exists:areas,id',
    ]);

    $observation = SafetyObservation::findOrFail($id);
    $observation->area_id = $request->area_id;
    $observation->save();

    return back()->with('success', 'Area berhasil ditunjuk sebagai SIC.');
}

}
