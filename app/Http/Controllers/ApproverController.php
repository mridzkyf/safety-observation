<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SafetyObservation;
use App\Events\SoClosedByManager;
use App\Events\SicStatusChanged;
use App\Models\User;
use App\Models\Area;



class ApproverController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $seksi = $user->nama_seksi;

        return view('approver.dashboard', compact('seksi'));
    }

    public function temuanSeksi(Request $request)
    {
        $user = Auth::user();
        $seksi = $user->nama_seksi;


        // Tabel atas (sedang diproses)
    // Inisialisasi query ongoing dan closed
    $ongoingQuery = SafetyObservation::query()
        ->where('nama_seksi', $seksi)
        ->whereIn('status', ['waiting', 'open', 'on_progress', 'pending']);

    $closedQuery = SafetyObservation::query()
        ->where('nama_seksi', $seksi)
        ->where('status', 'closed');

    // Filter untuk ongoing
    if ($request->filled('name_ongoing')) {
        $ongoingQuery->where('nama', 'like', '%' . $request->name_ongoing . '%');
    }
    if ($request->filled('email_ongoing')) {
        $ongoingQuery->where('email', 'like', '%' . $request->email_ongoing . '%');
    }
    if ($request->filled('kategori_ongoing')) {
        $ongoingQuery->where('kategori', 'like', '%' . $request->kategori_ongoing . '%');
    }
    if ($request->filled('judul_temuan_ongoing')) {
        $ongoingQuery->where('judul_temuan', 'like', '%' . $request->judul_temuan_ongoing . '%');
    }
    if ($request->filled('lokasi_observasi_ongoing')) {
        $ongoingQuery->where('lokasi_observasi', 'like', '%' . $request->lokasi_observasi_ongoing . '%');
    }
    if ($request->filled('status_ongoing')) {
        $ongoingQuery->where('status', $request->status_ongoing);
    }
    if ($request->filled('tanggal_pelaporan_ongoing')) {
        $ongoingQuery->whereDate('tanggal_pelaporan', $request->tanggal_pelaporan_ongoing);
    }

        //FIllter untuk closed
        if ($request->filled('name_closed')) {
            $closedQuery->where('name', 'like', '%' . $request->name_closed . '%');
        }
        if ($request->filled('email_closed')) {
            $closedQuery->where('email', 'like', '%' . $request->email_closed . '%');
        }
        if ($request->filled('kategori_closed')) {
            $closedQuery->where('kategori', 'like', '%' . $request->kategori_closed . '%');
        }
        if ($request->filled('judul_temuan_closed')) {
            $closedQuery->where('judul_temuan', 'like', '%' . $request->judul_temuan_closed . '%');
        }
        if ($request->filled('lokasi_observasi_closed')) {
            $closedQuery->where('lokasi_observasi', 'like', '%' . $request->lokasi_observasi_closed . '%');
        }
        if ($request->filled('status_closed')) {
            $closedQuery->where('status', 'like', '%' . $request->status_closed . '%');
        }
        if ($request->filled('tanggal_pelaporan_closed')) {
            $closedQuery->where('status', 'like', '%' . $request->tanggal_pelaporan_closed . '%');
        }
        // Eksekusi query
        $ongoing = $ongoingQuery->latest()->paginate(5,['*'],'on_progress')->withQueryString();
        $closed = $closedQuery->latest()->paginate(5,['*'],'closed')->withQueryString();
        //tanggal pelaporan, nama pelapor, email, 
        return view('approver.temuan', compact('ongoing', 'closed', 'seksi'));
    }
    public function terlapor(Request $request)
{
    $user = Auth::user();

    // Ambil semua SO yang ditujukan ke area user ini
    $ongoing_query = SafetyObservation::where('area_id', $user->area_id)
        ->whereIn('status', ['pending', 'on_progress', 'open']);
        // ->latest()
        // ->get();

    $closed_query = SafetyObservation::where('area_id', $user->area_id)
        ->where('status', 'closed');
        // ->latest()
        // ->get();

    // Filter untuk ongoing
    if ($request->filled('name_ongoing')) {
        $ongoing_query->where('nama', 'like', '%' . $request->name_ongoing . '%');
    }
    if ($request->filled('name_seksi_ongoing')) {
        $ongoing_query->where('nama_seksi', 'like', '%' . $request->name_seksi_ongoing . '%');
    }
    if ($request->filled('judul_temuan_ongoing')) {
        $ongoing_query->where('judul_temuan', 'like', '%' . $request->judul_temuan_ongoing . '%');
    }
    if ($request->filled('lokasi_observasi_ongoing')) {
        $ongoing_query->where('lokasi_observasi', 'like', '%' . $request->lokasi_observasi_ongoing . '%');
    }
    if ($request->filled('status_ongoing')) {
        $ongoing_query->where('status', $request->status_ongoing);
    }
    if ($request->filled('tanggal_pelaporan_ongoing')) {
        $ongoing_query->whereDate('tanggal_pelaporan', $request->tanggal_pelaporan_ongoing);
    }

    // Filter untuk closed
    if ($request->filled('name_closed')) {
        $closed_query->where('nama', 'like', '%' . $request->name_closed . '%');
    }
    if ($request->filled('name_seksi_closed')) {
        $closed_query->where('nama_seksi', 'like', '%' . $request->name_seksi_closed . '%');
    }
    if ($request->filled('judul_temuan_closed')) {
        $closed_query->where('judul_temuan', 'like', '%' . $request->judul_temuan_closed . '%');
    }
    if ($request->filled('lokasi_observasi_closed')) {
        $closed_query->where('lokasi_observasi', 'like', '%' . $request->lokasi_observasi_closed . '%');
    }
    if ($request->filled('status_closed')) {
        $closed_query->where('status', $request->status_closed);
    }
    if ($request->filled('tanggal_pelaporan_closed')) {
        $closed_query->whereDate('tanggal_pelaporan', $request->tanggal_pelaporan_closed);
    }
    $ongoing = $ongoing_query->latest()->paginate(5,['*'],'on_progress')->withQueryString();
    $closed = $closed_query->latest()->paginate(5,['*'],'closed')->withQueryString();

    return view('approver.terlapor', compact('ongoing', 'closed'));
}

    public function show($id, Request $request)
{
    $observation = SafetyObservation::findOrFail($id);

    // Ambil user yang bisa jadi SIC (admin, officer, supervisor, manager)
    $sicCandidates = User::whereIn('role', ['admin', 'officer', 'supervisor', 'manager'])->get();

    $areas = Area::all();

    // Ambil parameter ?source=terlapor atau default 'temuan'
    $source = $request->query('source', 'temuan');

    return view('approver.detail', compact('observation', 'sicCandidates', 'source','areas'));
}


public function approve(Request $request, $id)
{   
    $request->validate([
        'area_id' => 'required|exists:areas,id',
    ]);
    $r = $request;

    $observation = SafetyObservation::findOrFail($id);
    $observation->area_id = $request->area_id;
    $observation->status = 'open';
    $observation->save();
    event(new \App\Events\SoOpenedAndAssignedSic($observation));
    return redirect()->route('approver.temuan')->with('success', 'Laporan telah di-approve dan diteruskan ke SIC.');
}



public function updateStatusTerlapor(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:on_progress,pending,closed',
    ]);

    $observation = SafetyObservation::findOrFail($id);
    $old = $observation->status;
    $new = $request->status;
    // Validasi: hanya SIC yang ditunjuk yang bisa update
    if ($observation->area_id !== auth()->user()->area_id) {
        abort(403, 'Unauthorized');
    }

    if ($old === $new) {
        return back()->with('info', 'Status tidak berubah.');
    }

    $observation->status = $new;
    $observation->save();
    event(new SicStatusChanged($observation, $old, $new));

    return redirect()->back()->with('success', 'Status berhasil diperbarui.');
}



public function close($id, Request $r)
{
    $observation = SafetyObservation::findOrFail($id);

    // Optional: pastikan hanya role tertentu yang bisa close
    if (!in_array(auth()->user()->role, ['admin', 'officer', 'supervisor', 'manager'])) {
        abort(403, 'Unauthorized');
    }

    $observation->status = 'closed';
    $observation->save();
    event(new \App\Events\SoClosedByManager($observation));

    return redirect()->back()->with('success', 'Laporan telah ditandai sebagai CLOSED.');
}

}
