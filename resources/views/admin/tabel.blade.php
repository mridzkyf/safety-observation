<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Temuan</title>

    <!-- Bootstrap CSS for Pagination -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Custom & FontAwesome -->
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
            margin-bottom: 40px;
        }

        table th {
            background-color: #032E3D;
            color: #fff;
            text-align: center;
            font-weight: bold;
            padding: 10px;
        }

        table td {
            text-align: center;
            padding: 10px;
            background-color: #f9f9f9;
            color: #032E3D;
        }

        .btn-primary {
            background-color: #0A2B33;
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

        .text-muted {
            color: #6c757d !important;
        }

        .pagination .page-link {
            color: #0d6efd;
        }

        .pagination .active .page-link {
            background-color: #0d6efd;
            color: #fff;
        }

        .button-detail {
            background-color: #032E3D !important;
            color: #ffff !important;
            padding: 5px 12px;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 10px;
            display: inline-block;
            min-width: 90px;
            text-align: center;
        }
    </style>
</head>

<body>
    @include('layouts.header')

    <div class="content-wrapper">
        <a href="{{ route('admin.dashboard') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        <!-- ONGOING SECTION -->
        <div class="table-container">
            <h3 style="color:#032E3D; font-weight:bold;">Daftar Safety Observation (Sedang Diproses)</h3>

            <form method="GET" action="{{ route('admin.tabel') }}" class="mb-3">
                <div class="row g-2">
                    <div class="col-md">
                        <input type="date" name="tanggal_pelaporan" class="form-control form-control-sm"
                            value="{{ request('tanggal_pelaporan') }}">
                    </div>
                    <div class="col-md">
                        <input type="text" name="nama" class="form-control form-control-sm"
                            placeholder="Nama Pelapor" value="{{ request('nama') }}">
                    </div>
                    <div class="col-md">
                        <input type="text" name="nama_seksi" class="form-control form-control-sm" placeholder="Seksi"
                            value="{{ request('nama_seksi') }}">
                    </div>
                    <div class="col-md">
                        <input type="text" name="lokasi_observasi" class="form-control form-control-sm"
                            placeholder="Lokasi" value="{{ request('lokasi_observasi') }}">
                    </div>
                    <div class="col-md">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Semua</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="on_progress" {{ request('status') == 'on_progress' ? 'selected' : '' }}>On
                                Progress</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                        </select>
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-sm btn-info w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal Pelaporan</th>
                            <th>Nama Pelapor</th>
                            <th>Nama Seksi</th>
                            <th>Judul Temuan</th>
                            <th>Lokasi Observasi</th>
                            <th>Status</th>
                            <th>Detail</th>
                            <th>Ubah Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ongoing as $item)
                            <tr>
                                <td>{{ $item->tanggal_pelaporan }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nama_seksi }}</td>
                                <td>{{ $item->judul_temuan }}</td>
                                <td>{{ $item->lokasi_observasi }}</td>
                                <td>
                                    @php
                                        $bgColor = match ($item->status) {
                                            'pending' => '#dc3545',
                                            'on_progress' => '#ffc107',
                                            'closed' => '#28a745',
                                            'open' => '#0d6efd',
                                            default => '#6c757d',
                                        };
                                        $textColor = in_array($item->status, ['pending', 'on_progress'])
                                            ? '#000000'
                                            : '#ffffff';
                                    @endphp
                                    <span
                                        style="background-color: {{ $bgColor }}; color: {{ $textColor }}; padding: 5px 12px; font-size: 0.85rem; font-weight: 600; border-radius: 10px; display: inline-block; min-width: 90px;">
                                        {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.detail', ['id' => $item->id, 'source' => 'terlapor']) }}"
                                        class="button-detail">Lihat Detail</a>
                                </td>
                                <td>
                                    <form action="{{ route('approver.terlapor.update', $item->id) }}" method="POST">
                                        @csrf
                                        <select name="status" class="form-select" required>
                                            <option value="">Pilih</option>
                                            <option value="on_progress">On Progress</option>
                                            <option value="pending">Pending</option>
                                            <option value="closed">Closed</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary mt-1">Update</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada data observasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $ongoing->firstItem() ?? 0 }} – {{ $ongoing->lastItem() ?? 0 }} dari total
                        {{ $ongoing->total() }} data
                    </div>
                    <div>
                        {{ $ongoing->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- CLOSED SECTION -->
        <div class="table-container">
            <h3 style="color:#032E3D; font-weight:bold;">Riwayat Safety Observation</h3>

            <form method="GET" action="{{ route('admin.tabel') }}" class="mb-3">
                <div class="row g-2">
                    <div class="col-md">
                        <input type="date" name="tanggal_pelaporan" class="form-control form-control-sm"
                            value="{{ request('tanggal_pelaporan') }}">
                    </div>
                    <div class="col-md">
                        <input type="text" name="nama" class="form-control form-control-sm"
                            placeholder="Nama Pelapor" value="{{ request('nama') }}">
                    </div>
                    <div class="col-md">
                        <input type="text" name="nama_seksi" class="form-control form-control-sm" placeholder="Seksi"
                            value="{{ request('nama_seksi') }}">
                    </div>
                    <div class="col-md">
                        <input type="text" name="lokasi_observasi" class="form-control form-control-sm"
                            placeholder="Lokasi" value="{{ request('lokasi_observasi') }}">
                    </div>
                    <div class="col-md">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Semua</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="on_progress" {{ request('status') == 'on_progress' ? 'selected' : '' }}>On
                                Progress</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                        </select>
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-sm btn-info w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal Pelaporan</th>
                            <th>Nama Pelapor</th>
                            <th>Nama Seksi</th>
                            <th>Judul Temuan</th>
                            <th>Lokasi Observasi</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($closed as $item)
                            <tr>
                                <td>{{ $item->tanggal_pelaporan }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nama_seksi }}</td>
                                <td>{{ $item->judul_temuan }}</td>
                                <td>{{ $item->lokasi_observasi }}</td>
                                <td>
                                    <span
                                        style="background-color: #28a745; color: #fff; padding: 5px 12px; font-size: 0.85rem; font-weight: 600; border-radius: 10px; display: inline-block; min-width: 90px;">
                                        Closed
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.detail', ['id' => $item->id, 'source' => 'terlapor']) }}"
                                        class="button-detail">Lihat Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada riwayat observasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $closed->firstItem() ?? 0 }} – {{ $closed->lastItem() ?? 0 }} dari total
                        {{ $closed->total() }} data
                    </div>
                    <div>
                        {{ $closed->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
