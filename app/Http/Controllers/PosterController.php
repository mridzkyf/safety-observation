<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poster;
use Illuminate\Support\Facades\Storage;

class PosterController extends Controller
{
    public function index()
    {
        $poster = Poster::latest()->first(); // ambil poster terakhir
        return view('admin.poster.index', compact('poster'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'poster' => 'required|image|mimes:jpg,jpeg,png|max:20480'
        ]);

        // Simpan file ke storage
        $path = $request->file('poster')->store('posters', 'public');

        // Cek apakah sudah ada poster sebelumnya
        $poster = Poster::latest()->first();
        if ($poster) {
            // hapus file lama
            if ($poster->file_path && Storage::disk('public')->exists($poster->file_path)) {
                Storage::disk('public')->delete($poster->file_path);
            }
            $poster->update([
                'file_path' => $path
            ]);
        } else {
            // kalau belum ada → buat baru
            Poster::create([
                'file_path' => $path
            ]);
        }

        return back()->with('success', 'Poster berhasil diupdate.');
    }

    public function destroy()
    {
        $poster = Poster::latest()->first();
        if ($poster) {
            if ($poster->file_path && Storage::disk('public')->exists($poster->file_path)) {
                Storage::disk('public')->delete($poster->file_path);
            }
            $poster->delete();
        }
        return back()->with('success', 'Poster berhasil dihapus.');
    }
}
