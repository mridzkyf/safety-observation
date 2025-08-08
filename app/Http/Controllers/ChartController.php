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
    public function pieView()
    {
        return view('analisis.pie'); // <--- pastikan view ini ada
    }

}
