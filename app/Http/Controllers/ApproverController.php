<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SafetyObservation;
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

    public function temuanSeksi()
    {
        $user = Auth::user();
        $seksi = $user->nama_seksi;

        $observations = SafetyObservation::where('nama_seksi', $seksi)->latest()->get();

        return view('approver.temuan', compact('observations', 'seksi'));
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

    public function laporanTerlapor()
{
    $user = Auth::user();
    $observations = SafetyObservation::where('sic_id', $user->id)
                    ->where('status', 'open')
                    ->latest()->get();

    return view('approver.terlapor', compact('observations'));
}
public function approve(Request $request, $id)
{
    $request->validate([
        'area_id' => 'required|exists:areas,id',
    ]);

    $observation = SafetyObservation::findOrFail($id);
    $observation->area_id = $request->area_id;
    $observation->status = 'open';
    $observation->save();

    return redirect()->route('approver.temuan')->with('success', 'Laporan telah di-approve dan diteruskan ke SIC.');
}
public function terlapor()
{
    $user = Auth::user();

    // Ambil semua SO yang ditujukan ke area user ini
    $ongoing = SafetyObservation::where('area_id', $user->area_id)
        ->whereIn('status', ['pending', 'on_progress', 'open'])
        ->latest()
        ->get();

    $closed = SafetyObservation::where('area_id', $user->area_id)
        ->where('status', 'closed')
        ->latest()
        ->get();

    return view('approver.terlapor', compact('ongoing', 'closed'));
}


public function updateStatusTerlapor(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:on_progress,pending,closed',
    ]);

    $observation = SafetyObservation::findOrFail($id);

    // Validasi: hanya SIC yang ditunjuk yang bisa update
    if ($observation->area_id !== auth()->user()->area_id) {
        abort(403, 'Unauthorized');
    }

    $observation->status = $request->status;
    $observation->save();

    return redirect()->back()->with('success', 'Status berhasil diperbarui.');
}
public function close($id)
{
    $observation = SafetyObservation::findOrFail($id);

    // Optional: pastikan hanya role tertentu yang bisa close
    if (!in_array(auth()->user()->role, ['admin', 'officer', 'supervisor', 'manager'])) {
        abort(403, 'Unauthorized');
    }

    $observation->status = 'closed';
    $observation->save();

    return redirect()->back()->with('success', 'Laporan telah ditandai sebagai CLOSED.');
}

}
