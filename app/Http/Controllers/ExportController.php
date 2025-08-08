<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\SafetyObservationExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function exportAdmin(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:all,single,range',
            'date' => ['required_if:mode,single', 'nullable', 'date'],
            'start_date' => ['required_if:mode,range', 'nullable', 'date'],
            'end_date' => ['required_if:mode,range', 'nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $mode = $request->mode;

        if ($mode === 'all') {
            return Excel::download(new SafetyObservationExport(null, null, 'all', null), 'so_all_data.xlsx');
        }

        if ($mode === 'single') {
            return Excel::download(new SafetyObservationExport($request->date, $request->date, 'single', null), 'so_' . $request->date . '.xlsx');
        }

        if ($mode === 'range') {
            return Excel::download(new SafetyObservationExport($request->start_date, $request->end_date, 'range', null), 'so_' . $request->start_date . '_to_' . $request->end_date . '.xlsx');
        }

        return back()->withErrors('Mode filter tidak valid.');
    }

    public function exportManagerPelapor(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:all,single,range',
            'date' => ['required_if:mode,single', 'nullable', 'date'],
            'start_date' => ['required_if:mode,range', 'nullable', 'date'],
            'end_date' => ['required_if:mode,range', 'nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $user = Auth::user();
        $seksi = $user->nama_seksi;
        $mode = $request->mode;

        if ($mode === 'all') {
            return Excel::download(new SafetyObservationExport(null, null, 'all', $seksi), 'so_seksi_' . $seksi . '.xlsx');
        }

        if ($mode === 'single') {
            return Excel::download(new SafetyObservationExport($request->date, $request->date, 'single', $seksi), 'so_seksi_' . $seksi . '_' . $request->date . '.xlsx');
        }

        if ($mode === 'range') {
            return Excel::download(new SafetyObservationExport($request->start_date, $request->end_date, 'range', $seksi), 'so_seksi_' . $seksi . '_' . $request->start_date . '_to_' . $request->end_date . '.xlsx');
        }

        return back()->withErrors('Mode filter tidak valid.');
    }

    public function exportManagerTerlapor(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:all,single,range',
            'date' => ['required_if:mode,single', 'nullable', 'date'],
            'start_date' => ['required_if:mode,range', 'nullable', 'date'],
            'end_date' => ['required_if:mode,range', 'nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $user = Auth::user();
        $seksi = $user->nama_seksi;
        $mode = $request->mode;

        if ($mode === 'all') {
            return Excel::download(new SafetyObservationExport(null, null, 'all', $seksi, true), 'so_terlapor_area_' . $seksi . '.xlsx');
        }

        if ($mode === 'single') {
            return Excel::download(new SafetyObservationExport($request->date, $request->date, 'single', $seksi, true), 'so_terlapor_area_' . $seksi . '_' . $request->date . '.xlsx');
        }

        if ($mode === 'range') {
            return Excel::download(new SafetyObservationExport($request->start_date, $request->end_date, 'range', $seksi, true), 'so_terlapor_area_' . $seksi . '_' . $request->start_date . '_to_' . $request->end_date . '.xlsx');
        }

        return back()->withErrors('Mode filter tidak valid.');
    }
}

