<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit SIC Area</title>
    <link rel="stylesheet" href="{{ asset('argon/css/dashboard-custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #032E3D;
            color: #fff;
        }

        .content-wrapper {
            padding: 40px;
        }

        .table-container {
            background-color: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }

        table {
            width: 100%;
        }

        table th {
            background-color: #032E3D;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            text-align: center;
        }

        table td {
            padding: 10px;
            color: #032E3D;
            background-color: #f9f9f9;
            text-align: center;
        }

        .btn-primary {
            background-color: #0A2B33;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            font-size: 0.85rem;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            font-size: 0.85rem;
        }

        .btn-danger:hover {
            background-color: #b02a37;
        }

        .btn-success {
            background-color: #198754;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            font-size: 0.85rem;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #0098be;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
        }

        .input-group {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .form-control {
            flex: 1;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    @include('layouts.header')
    <div class="content-wrapper">
        <a href="{{ route('admin.area.index') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Area
        </a>

        <h3 style="margin-bottom: 20px;">Edit Perwakilan SIC Area: <span
                style="color: #ffc107">{{ $area->name }}</span></h3>

        @if (session('success'))
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

        <div class="table-container">
            <!-- Form Pencarian User -->
            <form method="GET" action="{{ route('admin.area.edit', $area->id) }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama user..."
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>

            <!-- Tabel Perwakilan -->
            <h5 style="color:#032E3D; font-weight:bold;">Perwakilan Saat Ini</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Seksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($area->users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>{{ $user->nama_seksi }}</td>
                            <td>
                                <form method="POST"
                                    action="{{ route('admin.area.removeUser', [$area->id, $user->id]) }}"
                                    class="form-delete-user d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-remove-user"
                                        data-nama="{{ $user->name }}">
                                        Hapus dari Area
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted text-center">Belum ada user di area ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- SweetAlert Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-remove-user');

            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    const namaUser = this.dataset.nama;

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: `User ${namaUser} akan dihapus dari SIC Area ini.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>
