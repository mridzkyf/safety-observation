@extends('layouts.blank')

@section('content')
    <div class="admin-user-form-wrapper">
        <a href="{{ route('admin.users.tabeluser') }}" class="btn btn-danger mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar User
        </a>
        <h3 class="mb-4 text-black">Edit User</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password">Password Baru (Opsional)</label>
                    <input type="password" name="password" class="form-control"
                        placeholder="Biarkan kosong jika tidak ingin mengubah">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nama_seksi">Nama Seksi</label>
                    <select name="nama_seksi" class="form-select" required>
                        <option value="">-- Pilih Seksi --</option>
                        @foreach ($daftarSeksi as $seksi)
                            <option value="{{ $seksi }}"
                                {{ old('nama_seksi', $user->nama_seksi) == $seksi ? 'selected' : '' }}>
                                {{ $seksi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="group">Group Kerja</label>
                    <select name="group" class="form-select" required>
                        <option value="">-- Pilih Group --</option>
                        @foreach (['DAY TIME', 'GROUP A', 'GROUP B', 'GROUP C', 'GROUP D'] as $group)
                            <option value="{{ $group }}"
                                {{ old('group', $user->group) == $group ? 'selected' : '' }}>
                                {{ $group }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="role">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach (['user', 'officer', 'supervisor', 'asistant_manager', 'manager'] as $role)
                            <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="area_id" class="form-label">Area Kerja</label>
                    <select name="area_id" id="area_id" class="form-select" required>
                        <option value="">-- Pilih Area --</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" {{ $user->area_id == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
        </form>
    </div>
@endsection
