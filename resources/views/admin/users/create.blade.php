@extends('layouts.blank')

@section('content')
    <div class="admin-user-form-wrapper">
        <a href="{{ auth()->user()->is_admin ? route('admin.users.dashusers') : route('user.dashboard') }}"
            class="btn btn-danger mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        <h3 class="mb-4 text-black">Tambah User Baru</h3>
        @if (session('success'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        @endif
        <div class="form-wrapper">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email User</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password Sementara</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nama_seksi" class="form-label">Nama Seksi</label>
                        <select name="nama_seksi" id="nama_seksi" class="form-select" required>
                            <option value="">-- Pilih Seksi --</option>
                            @foreach ($daftarSeksi as $seksi)
                                <option value="{{ $seksi }}">{{ $seksi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="group" class="form-label">Group Kerja</label>
                        <select name="group" id="group" class="form-select" required>
                            <option value="">-- Pilih Group --</option>
                            <option value="DAY TIME">DAY TIME</option>
                            <option value="GROUP A">GROUP A</option>
                            <option value="GROUP B">GROUP B</option>
                            <option value="GROUP C">GROUP C</option>
                            <option value="GROUP D">GROUP D</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="user">User</option>
                            <option value="officer">Officer</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="asistant_manager">Asistant Manager</option>
                            <option value="manager">Manager</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="area_id" class="form-label">Area Kerja</label>
                        <select name="area_id" id="area_id" class="form-select" required>
                            <option value="">-- Pilih Area --</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Simpan User</button>
            </form>
        </div>
    </div>
@endsection
