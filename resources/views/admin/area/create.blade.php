@extends('layouts.blank')

@section('content')
    <div class="admin-user-form-wrapper">
        <a href="{{ auth()->user()->is_admin ? route('admin.area.index') : route('user.dashboard') }}"
            class="btn btn-danger mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        <h3 class="mb-4 text-black">Tambah Area Baru</h3>

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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-wrapper">
            <form action="{{ route('admin.area.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Area</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Simpan Area</button>
            </form>
        </div>
    </div>
@endsection
