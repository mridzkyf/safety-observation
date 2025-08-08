<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Temuan</title>
    <!-- Bootstrap CSS for Pagination -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('argon/css/dashboard-custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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

        .btn-primary:hover {
            background-color: #145c73;
        }

        .pagination {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 1rem;
            gap: 2px;
        }

        .pagination-info {
            color: #032E3D;
            font-size: 14px;
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

        @media (min-width: 992px) {
            .col-lg-1-5 {
                flex: 0 0 auto;
                width: 13.8%;
                /* 1.5 dari 12 kolom (1.5/12 = 12.5%) */
            }

            .col-lg-1-6 {
                flex: 0 0 auto;
                width: 16.5%;
                /* 1.5 dari 12 kolom (1.5/12 = 12.5%) */
            }
        }
    </style>
</head>

<body>
    @include('layouts.header')
    <div class="content-wrapper">
        <a href="{{ route('approver.dashboard') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        <!-- Bagian 1: Ongoing -->
        <div class="table-container">
            <h3 style="color:#032E3D; font-weight:bold; margin-bottom:20px;">Daftar Safety Observation (Sedang Diproses)
            </h3>
            <form method="GET" action="{{ route('approver.terlapor') }}" class="mb-3">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-1-5 col-md-3 col-sm-6">
                        <input type="date" name="tanggal_pelaporan_ongoing" class="form-control form-control-sm"
                            value="{{ request('tanggal_pelaporan_ongoing') }}">
                    </div>
                    <div class="col-lg-1-5 col-md-3 col-sm-6">
                        <input type="text" name="name_ongoing" class="form-control form-control-sm"
                            placeholder="Nama Pelapor" value="{{ request('name_ongoing') }}">
                    </div>
                    <div class="col-lg-1-5 col-md-3 col-sm-6">
                        <input type="text" name="nama_seksi_ongoing" class="form-control form-control-sm"
                            placeholder="Nama Seksi" value="{{ request('nama_seksi_ongoing') }}">
                    </div>
                    <div class="col-lg-1-5 col-md-3 col-sm-6">
                        <input type="text" name="judul_temuan_ongoing" class="form-control form-control-sm"
                            placeholder="Judul Temuan" value="{{ request('judul_temuan_ongoing') }}">
                    </div>
                    <div class="col-lg-1-5 col-md-3 col-sm-6">
                        <input type="text" name="lokasi_observasi_ongoing" class="form-control form-control-sm"
                            placeholder="Lokasi Observasi" value="{{ request('lokasi_observasi_ongoing') }}">
                    </div>
                    <div class="col-lg-1-5 col-md-3 col-sm-6">
                        <select name="status_ongoing" class="form-select form-select-sm">
                            <option value="">Status</option>
                            <option value="waiting" {{ request('status_ongoing') == 'waiting' ? 'selected' : '' }}>
                                Waiting</option>
                            <option value="open" {{ request('status_ongoing') == 'open' ? 'selected' : '' }}>Open
                            </option>
                            <option value="on_progress"
                                {{ request('status_ongoing') == 'on_progress' ? 'selected' : '' }}>On Progress</option>
                            <option value="pending" {{ request('status_ongoing') == 'pending' ? 'selected' : '' }}>
                                Pending</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-3 col-sm-6">
                        <button type="submit" class="btn btn-sm btn-info w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                    <div class="col-lg-1 col-md-3 col-sm-6">
                        <a type = "submit" class = "btn btn-sm btn-danger w-100"
                            href="{{ route('approver.terlapor') }}">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
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
                                        style="background-color: {{ $bgColor }}; color: {{ $textColor }};
                                        padding: 5px 12px; font-size: 0.85rem; font-weight: 600;
                                        border-radius: 10px; display: inline-block; min-width: 90px;">
                                        {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('approver.temuan.detail', ['id' => $item->id, 'source' => 'terlapor']) }}"
                                        class="btn btn-primary">Lihat Detail</a>
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
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                    <div class="pagination-info">
                        Menampilkan {{ $ongoing->firstItem() }} – {{ $ongoing->lastItem() }} dari total
                        {{ $ongoing->total() }} data
                    </div>
                    <div class="pagination">
                        {{ $ongoing->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian 2: Closed -->
        <div class="table-container">
            <h3 style="color:#032E3D; font-weight:bold; margin-bottom:20px;">Riwayat Safety Observation (History)
            </h3>
            <form method="GET" action="{{ route('approver.terlapor') }}" class="mb-3">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-1-6 col-md-3 col-sm-6">
                        <input type="date" name="tanggal_pelaporan_closed" class="form-control form-control-sm"
                            value="{{ request('tanggal_pelaporan_closed') }}">
                    </div>
                    <div class="col-lg-1-6 col-md-3 col-sm-6">
                        <input type="text" name="name_closed" class="form-control form-control-sm"
                            placeholder="Nama Pelapor" value="{{ request('name_closed') }}">
                    </div>
                    <div class="col-lg-1-6 col-md-3 col-sm-6">
                        <input type="text" name="nama_seksi_closed" class="form-control form-control-sm"
                            placeholder="Nama Seksi" value="{{ request('nama_seksi_Closed') }}">
                    </div>
                    <div class="col-lg-1-6 col-md-3 col-sm-6">
                        <input type="text" name="judul_temuan_closed" class="form-control form-control-sm"
                            placeholder="Judul Temuan" value="{{ request('judul_temuan_closed') }}">
                    </div>
                    <div class="col-lg-1-6 col-md-3 col-sm-6">
                        <input type="text" name="lokasi_observasi_closed" class="form-control form-control-sm"
                            placeholder="Lokasi Observasi" value="{{ request('lokasi_observasi_closed') }}">
                    </div>
                    <div class="col-lg-1 col-md-3 col-sm-6">
                        <button type="submit" class="btn btn-sm btn-info w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                    <div class="col-lg-1 col-md-3 col-sm-6">
                        <a type = "submit" class = "btn btn-sm btn-danger w-100"
                            href="{{ route('approver.terlapor') }}">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
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
                                        style="background-color: #28a745; color: #fff;
                                        padding: 5px 12px; font-size: 0.85rem; font-weight: 600;
                                        border-radius: 10px; display: inline-block; min-width: 90px;">
                                        Closed
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('approver.temuan.detail', ['id' => $item->id, 'source' => 'terlapor']) }}"
                                        class="btn btn-primary">Lihat Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada riwayat observasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                    <div class="pagination-info">
                        Menampilkan {{ $closed->firstItem() }} – {{ $closed->lastItem() }} dari total
                        {{ $closed->total() }} data
                    </div>
                    <div class="pagination">
                        {{ $closed->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
        {{-- Form download export (Excel) --}}
        <div class="table-container">
            <h3 style="color:#032E3D; font-weight:bold;">Export Data Safety Observation</h3>
            <form action="{{ route('manager.export.terlapor') }}" method="GET"
                class="d-flex align-items-center gap-2 mb-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <select name="mode" id="filterMode" class="form-control" required>
                    <option value="all">Semua Data</option>
                    <option value="single">Per Tanggal</option>
                    <option value="range">Range Tanggal</option>
                </select>

                <input type="date" name="date" id="singleDate" class="form-control d-none">
                <input type="date" name="start_date" id="startDate" class="form-control d-none">
                <input type="date" name="end_date" id="endDate" class="form-control d-none">

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
            </form>
        </div>
    </div>
</body>
<script>
    const modeSelect = document.getElementById('filterMode');
    const singleDate = document.getElementById('singleDate');
    const startDate = document.getElementById('startDate');
    const endDate = document.getElementById('endDate');

    function updateDateInputs() {
        let mode = modeSelect.value;

        singleDate.classList.add('d-none');
        singleDate.required = false;
        startDate.classList.add('d-none');
        startDate.required = false;
        endDate.classList.add('d-none');
        endDate.required = false;

        if (mode === 'single') {
            singleDate.classList.remove('d-none');
            singleDate.required = true;
        } else if (mode === 'range') {
            startDate.classList.remove('d-none');
            endDate.classList.remove('d-none');
            startDate.required = true;
            endDate.required = true;
        }
    }

    modeSelect.addEventListener('change', updateDateInputs);
    document.addEventListener('DOMContentLoaded', updateDateInputs);
</script>

</html>
