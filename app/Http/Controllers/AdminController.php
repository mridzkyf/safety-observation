<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SafetyObservation;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Area;

class AdminController extends Controller
{
        public function index()
    {
        $observations = SafetyObservation::latest()->get();
        return view('admin.dashboard', compact('observations'));
    }
    public function dashUsers()
{
    return view('admin.users.dashusers');
}

        // Fungsi dashboard dan lainnya…

    public function createUser()
    {
        // Bisa juga ambil daftar seksi untuk dropdown
        $daftarSeksi = [
            'ADM', 'Account & Tax','CA','EI','ENG PET','FT','IFB','IFC','IT','KTF','LOG','MC','MFG PET','MKF PF','Material Purchasing','QA & CTS KTF - PF','QC KTF - PF','QQC PET','SHE','TC', // dsb.
        ];
        $areas = Area::all(); // Ambil semua area

        return view('admin.users.create', compact('daftarSeksi','areas'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
            'nama_seksi' => 'required|string',
            'group' => 'required|in:DAY TIME,GROUP A,GROUP B,GROUP C,GROUP D',
            'role' => 'required|in:user,officer,supervisor,asistant_manager,manager', // <== custom role
            'area_id' => 'required|exists:areas,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama_seksi' => $request->nama_seksi,
            'group' => $request->group,
            'role' => $request->role, // gunakan role untuk membedakan
            'area_id' => $request->area_id,
            'is_admin' => $request->role === 'admin' ? 1 : 0,
        ]);

        // return redirect()->route('admin.dashboard')->with('success', 'User berhasil ditambahkan');
        return redirect()->route('admin.users.create')->with('success', 'User berhasil ditambahkan');
    }
    public function editUser($id)
{
    $user = User::findOrFail($id);
    $daftarSeksi = [
        'ADM', 'Account & Tax', 'CA', 'EI', 'ENG PET', 'FT', 'IFB', 'IFC', 'IT', 'KTF', 'LOG',
        'MC', 'MFG PET', 'MKF PF', 'Material Purchasing', 'QA & CTS KTF - PF', 'QC KTF - PF',
        'QQC PET', 'SHE', 'TC'
    ];
    $areas = Area::all();

    return view('admin.users.edit', compact('user', 'daftarSeksi','areas'));
}

public function updateUser(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => "required|email|unique:users,email,$id",
        'nama_seksi' => 'nullable|string',
        'group' => 'nullable|in:DAY TIME,GROUP A,GROUP B,GROUP C,GROUP D',
        'role' => 'required|in:user,officer,supervisor,asistant_manager,manager',
        'area_id' => 'nullable|exists:areas,id',
        'password' => 'nullable|string|min:8|confirmed', // password opsional
    ]);

    $user = User::findOrFail($id);

    // Buat array data untuk update
    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'nama_seksi' => $request->nama_seksi,
        'group' => $request->group,
        'role' => $request->role,
        'area_id' => $request->area_id,
    ];

    // Tambahkan password jika diisi
    if (!empty($request->password)) {
        $data['password'] = Hash::make($request->password);
    }

    // Update user dengan data lengkap
    $user->update($data);

    return redirect()->route('admin.users.tabeluser')->with('success', 'User berhasil diperbarui');
}

public function deleteUser($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'User berhasil dihapus.');
}

    public function show($id)
{
    $item = SafetyObservation::findOrFail($id);
    $sicCandidates = User::whereIn('role', ['officer', 'supervisor', 'asistant_manager','manager'])->get();
    return view('admin.detail', compact('item','sicCandidates'));
}

//for showing tabel
public function tabel(Request $request)
{
    // Inisialisasi query untuk ongoing dan closed secara terpisah
    $ongoingQuery = SafetyObservation::query()
        ->whereIn('status', ['waiting','open', 'on_progress', 'pending']);

    $closedQuery = SafetyObservation::query()
        ->where('status', 'closed');

    // Filtering ongoing
    if ($request->filled('nama_ongoing')) {
        $ongoingQuery->where('nama', 'like', '%' . $request->nama_ongoing . '%');
    }

    if ($request->filled('nama_seksi_ongoing')) {
        $ongoingQuery->where('nama_seksi', 'like', '%' . $request->nama_seksi_ongoing . '%');
    }

    if ($request->filled('lokasi_observasi_ongoing')) {
        $ongoingQuery->where('lokasi_observasi', 'like', '%' . $request->lokasi_observasi_ongoing . '%');
    }

    if ($request->filled('tanggal_pelaporan_ongoing')) {
        $ongoingQuery->whereDate('tanggal_pelaporan', $request->tanggal_pelaporan_ongoing);
    }

    if ($request->filled('kategori_ongoing')) {
        $ongoingQuery->where('kategori', $request->kategori_ongoing);
    }

    if ($request->filled('status_ongoing')) {
        $ongoingQuery->where('status', $request->status_ongoing); // ini hanya aktif jika user set status filter jadi open/on_progress/pending
    }
    //fillter closed
    if ($request->filled('nama_closed')) {
        $closedQuery->where('nama', 'like', '%' . $request->nama_closed. '%');
    }
    if ($request->filled('nama_seksi_closed')) {
        $closedQuery->where('nama_seksi', 'like', '%' . $request->nama_seksi_closed . '%');
    }
    if ($request->filled('lokasi_observasi_closed')) {
        $closedQuery->where('lokasi_observasi', 'like', '%' . $request->lokasi_observasi_closed . '%');
    }
    if ($request->filled('kategori_closed')) {
        $closedQuery->where('kategori', 'like', '%' . $request->kategori_closed . '%');
    }
    if ($request->filled('tanggal_pelaporan_closed')) {
        $closedQuery->whereDate('tanggal_pelaporan', $request->tanggal_pelaporan_closed);
    }
    if ($request->filled('status_closed')) {
        $ongoingQuery->where('status', $request->status_closed); // ini hanya aktif jika user set status filter jadi open/on_progress/pending
    }

    // Eksekusi query
    $ongoing = $ongoingQuery->latest()->paginate(5,['*'],'ongoing_page')->withQueryString();
    $closed = $closedQuery->latest()->paginate(5,['*'],'closed_page')->withQueryString();

    return view('admin.tabel', compact('ongoing', 'closed'));
}


public function listUsers(Request $request)
{
    $query = User::where('is_admin', 0);

    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }
    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }
    if ($request->filled('seksi')) {
        $query->where('nama_seksi', 'like', '%' . $request->seksi . '%');
    }
    if ($request->filled('role')) {
        $query->where('role', 'like', '%' . $request->role . '%');
    }
    if ($request->filled('group')) {
        $query->where('group', 'like', '%' . $request->group . '%');
    }

    $users = $query->paginate(10)->appends($request->query());
    return view('admin.users.tabeluser', compact('users'));
}


// List semua area beserta user-nya
public function indexArea(Request $request)
{
    $query = Area::with('users');

    if ($request->has('name') && $request->name != '') {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    $areas = $query->paginate(10)->withQueryString(); // <= paginasi 10 per halaman

    return view('admin.area.index', compact('areas'));
}

// Form tambah area
public function createArea()
{
    return view('admin.area.create');
}

// Simpan area baru
public function storeArea(Request $request)
{
    $request->validate([
        'name' => 'required|unique:areas,name',
    ]);

    Area::create([
        'name' => $request->name,
    ]);

    return redirect()->route('admin.area.index')->with('success', 'Area berhasil ditambahkan');
}
// Tampilkan form edit
public function editArea(Request $request, $id)
{
    $area = Area::with('users')->findOrFail($id);
    $searchUsers = [];
    if ($request->filled('search')) {
        $searchUsers = User::where('name', 'LIKE', '%' . $request->search . '%')
            ->where(function ($q) use ($area) {
                $q->whereNull('area_id')
                  ->orWhere('area_id', '!=', $area->id);
            })
            ->whereIn('role', ['officer', 'supervisor', 'asistant_manager', 'manager'])
            ->get();
    }
    return view('admin.area.edit', compact('area', 'searchUsers'));
}

// Update data area dan user perwakilan
public function updateArea(Request $request, $id)
{
    $area = Area::findOrFail($id);

    $request->validate([
        'name' => 'required|string|unique:areas,name,' . $area->id,
        'user_ids' => 'nullable|array',
    ]);

    $area->name = $request->name;
    $area->save();

    // Kosongkan dulu area dari semua user sebelumnya
    User::where('area_id', $area->id)->update(['area_id' => null]);

    // Tambahkan user baru ke area ini
    if ($request->has('user_ids')) {
        User::whereIn('id', $request->user_ids)->update(['area_id' => $area->id]);
    }

    return redirect()->route('admin.area.index')->with('success', 'Area berhasil diperbarui.');
}

// Hapus area
public function deleteArea($id)
{
    $area = Area::findOrFail($id);

    // Kosongkan area_id dari semua user di area ini
    User::where('area_id', $area->id)->update(['area_id' => null]);

    $area->delete();

    return redirect()->route('admin.area.index')->with('success', 'Area berhasil dihapus.');
}

public function assignUserToArea(Area $area, User $user)
{
    $user->area_id = $area->id;
    $user->save();

    return redirect()->route('admin.area.edit', $area->id)->with('success', 'User ditambahkan ke area.');
}

public function removeUserFromArea(Area $area, User $user)
{
    // pastikan user memang dari area ini
    if ($user->area_id === $area->id) {
        $user->area_id = null;
        $user->save();
    }

    return redirect()->route('admin.area.edit', $area->id)->with('success', 'User dihapus dari area.');
}
}
