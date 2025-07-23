<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIC Area</title>
    <link rel="stylesheet" href="{{ asset('argon/css/dashboard-custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
            margin-bottom: 40px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background-color: white;
            color: #032E3D;
            font-weight: bold;
            text-align: center;
            border: 1px solid #ddd;
            padding: 12px;
        }

        .table td {
            color: #032E3D;
            background-color: #f9f9f9;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            vertical-align: middle;
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

        .btn-primary:hover {
            background-color: #145c73;
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

        .table-responsive {
            overflow-x: auto;
        }

        .d-flex.gap-2>* {
            margin-right: 6px;
        }

        .d-flex.gap-2>*:last-child {
            margin-right: 0;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            /* jarak antar tombol */
            flex-wrap: wrap;
            /* agar responsif di layar sempit */
        }

        .btn-success {
            background-color: #198754;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            font-size: 0.85rem;
        }

        .heading-section {
            font-size: 24px;
            color: #032E3D;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .filter-row {
            display: flex;
            flex-wrap: nowrap;
            gap: 12px;
            margin-bottom: 16px;
        }

        .filter-row input {
            flex: 1;
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #ccc;
            color: #032E3D;
            min-width: 200px;
        }

        .filter-row button {
            padding: 6px 16px;
            font-size: 14px;
            border-radius: 6px;
            background-color: #0A2B33;
            color: white;
            border: none;
            white-space: nowrap;
        }

        .pagination {
            margin-top: 16px;
            display: flex;
            justify-content: center;
            color: #032E3D;
        }

        .pagination>nav>div>span,
        .pagination>nav>div>a {
            font-size: 14px;
            padding: 6px 10px;
            margin: 0px;
        }
    </style>
</head>

<body>
    @include('layouts.header')
    <div class="content-wrapper">
        <a href="{{ route('admin.users.dashusers') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

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
            <h3 class="heading-section">Daftar Area & Perwakilan</h3>
            <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 24px;">
                <a href="{{ route('admin.area.create') }}" class="btn btn-success" style="min-width: 140px;">
                    <i class="fas fa-plus"></i> Tambah Area
                </a>
            </div>

            <div class="table-responsive">
                <form method="GET" action="{{ route('admin.area.index') }}" class="filter-row mb-3">
                    <input type="text" name="name" placeholder="Cari nama area..." value="{{ request('name') }}">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Filter</button>
                </form>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Area</th>
                            <th>Officer</th>
                            <th>Supervisor</th>
                            <th>Assistant Manager</th>
                            <th>Manager</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($areas as $area)
                            <tr>
                                <td>{{ $area->name }}</td>
                                <td>
                                    @foreach ($area->users->where('role', 'officer') as $u)
                                        {{ $u->name }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($area->users->where('role', 'supervisor') as $u)
                                        {{ $u->name }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($area->users->where('role', 'asistant_manager') as $u)
                                        {{ $u->name }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($area->users->where('role', 'manager') as $u)
                                        {{ $u->name }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="action-buttons d-flex gap-2 justify-content-center">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="window.location='{{ route('admin.area.edit', $area->id) }}'">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('admin.area.delete', $area->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus area ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada area terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                    <div class="text-muted small">
                        Menampilkan {{ $areas->firstItem() }} – {{ $areas->lastItem() }} dari total
                        {{ $areas->total() }} data
                    </div>
                    <div class="pagination">
                        {{ $areas->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
