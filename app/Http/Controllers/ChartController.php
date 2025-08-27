<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ChartController extends Controller
{
public function pieData(Request $request)
{
    $query = DB::table('safety_observations');

    if ($request->filterMode === 'single') {
        $query->whereDate('tanggal_pelaporan', $request->singleDate);
    } elseif ($request->filterMode === 'range') {
        $query->whereBetween('tanggal_pelaporan', [$request->startDate, $request->endDate]);
    }

    $unsafeAction = (clone $query)->where('kategori', 'Unsafe Condition')->count();
    $unsafeCondition = (clone $query)->where('kategori', 'Unsafe Act')->count();

    return response()->json([
        'labels' => ['Unsafe Action', 'Unsafe Condition'],
        'data' => [$unsafeAction, $unsafeCondition]
    ]);
}
public function pieDataStatus(Request $request)
{
    $query = DB::table('safety_observations');

    if ($request->filterMode === 'single') {
        $query->whereDate('tanggal_pelaporan', $request->singleDate);
    } elseif ($request->filterMode === 'range') {
        $query->whereBetween('tanggal_pelaporan', [$request->startDate, $request->endDate]);
    }

    $data = [
        'closed' => (clone $query)->where('status', 'closed')->count(),
        'waiting' => (clone $query)->where('status', 'waiting')->count(),
        'open' => (clone $query)->where('status', 'open')->count(),
        'on_progress' => (clone $query)->where('status', 'on_progress')->count(),
        'pending' => (clone $query)->where('status', 'pending')->count(),
    ];

    return response()->json([
        'labels' => ['Closed', 'Waiting', 'Open', 'On Progress', 'Pending'],
        'data' => array_values($data)
    ]);
}

public function pieSeksiData(Request $request)
{
    $allSeksi = DB::table('areas')->pluck('name')->toArray();

    $query = DB::table('safety_observations');

    if ($request->filterMode === 'single') {
        $query->whereDate('tanggal_pelaporan', $request->singleDate);
    } elseif ($request->filterMode === 'range') {
        $query->whereBetween('tanggal_pelaporan', [$request->startDate, $request->endDate]);
    }

    $counts = $query
        ->select('nama_seksi', DB::raw('COUNT(*) as jumlah'))
        ->groupBy('nama_seksi')
        ->pluck('jumlah', 'nama_seksi');

    $labels = [];
    $data = [];

    foreach ($allSeksi as $seksi) {
        $labels[] = $seksi;
        $data[] = $counts[$seksi] ?? 0;
    }

    return response()->json([
        'labels' => $labels,
        'data' => $data
    ]);
}

public function barByAreaData(Request $request)
{
    $areas = DB::table('areas')->get();

    $labels = [];
    $unsafeActions = [];
    $unsafeConditions = [];

    foreach ($areas as $area) {
        $labels[] = $area->name;

        $query = DB::table('safety_observations')->where('area_id', $area->id);

        if ($request->filterMode === 'single') {
            $query->whereDate('tanggal_pelaporan', $request->singleDate);
        } elseif ($request->filterMode === 'range') {
            $query->whereBetween('tanggal_pelaporan', [$request->startDate, $request->endDate]);
        }

        $unsafeActions[] = (clone $query)->where('kategori', 'Unsafe Act')->count();
        $unsafeConditions[] = (clone $query)->where('kategori', 'Unsafe Condition')->count();
    }

    return response()->json([
        'labels' => $labels,
        'unsafeActions' => $unsafeActions,
        'unsafeConditions' => $unsafeConditions
    ]);
}

public function lineJenisTemuanData(Request $request)
{
    $query = DB::table('safety_observations');

    // Filter berdasarkan range tanggal
    if ($request->filterMode === 'range') {
        $query->whereBetween('tanggal_pelaporan', [$request->startDate, $request->endDate]);
    }

    if ($request->filterMode === 'single') {
        $query->whereDate('tanggal_pelaporan', $request->singleDate);
    }

    if ($request->has('area_id') && $request->area_id !== 'all') {
        $query->where('area_id', $request->area_id);
    }

    // Filter area_id (jika ada)
    if ($request->has('area_id') && $request->area_id !== 'all') {
        $query->where('area_id', $request->area_id);
    }

    $data = $query
        ->select('jenis_temuan', DB::raw('DATE(tanggal_pelaporan) as tanggal'), DB::raw('COUNT(*) as jumlah'))
        ->groupBy('jenis_temuan', DB::raw('DATE(tanggal_pelaporan)'))
        ->orderBy('tanggal')
        ->get();

    $grouped = [];

    foreach ($data as $row) {
        $grouped[$row->jenis_temuan][$row->tanggal] = $row->jumlah;
    }

    $tanggalList = collect($data)->pluck('tanggal')->unique()->sort()->values();

    $datasets = [];
    $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#009688', '#795548'];

    $i = 0;
    foreach ($grouped as $jenis => $values) {
        $datasets[] = [
            'label' => $jenis,
            'data' => $tanggalList->map(fn($tgl) => $values[$tgl] ?? 0)->toArray(),
            'borderColor' => $colors[$i % count($colors)],
            'fill' => false,
            'tension' => 0.4
        ];
        $i++;
    }

    return response()->json([
        'labels' => $tanggalList,
        'datasets' => $datasets
    ]);
}

    public function pieView()
    {
        return view('analisis.pie'); // <--- pastikan view ini ada
    }

}
