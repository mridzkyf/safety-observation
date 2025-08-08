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

        form .form-control,
        form .form-select {
            min-width: 140px;
            height: 36px;
            font-size: 14px;
            border-radius: 6px;
            color: #032E3D;
            border: 1px solid #ccc;
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

        .filter-row input,
        .filter-row select {
            height: 36px;
            font-size: 14px;
            border-radius: 6px;
            color: #032E3D;
            border: 1px solid #ccc;
            padding: 4px 10px;
            min-width: 120px;
        }

        .filter-row .btn-primary {
            background-color: #032E3D;
            color: #fff !important;
            border: none;
            border-radius: 6px;
            padding: 6px 14px;
            font-size: 14px;
            height: 36px;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .filter-row .btn-primary:hover {
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

        .heading-section {
            font-size: 24px;
            color: #032E3D;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .button-detail {
            background-color: #032E3D !important;
            color: #fff !important;
            padding: 5px 12px;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 10px;
            display: inline-block;
            min-width: 90px;
            text-align: center;
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

        .form-wrapper {
            max-width: 100%;
            margin-bottom: 20px;
        }

        .form-wrapper>form {
            max-width: 100%;
            margin: auto;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
            padding-left: 12px;
            padding-right: 12px;
        }

        .filter-form-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
            width: 100%;
            max-width: 100%;
        }

        .filter-form-wrapper input,
        .filter-form-wrapper select {
            flex: 1 1 200px;
            min-width: 160px;
            height: 36px;
            font-size: 14px;
            border-radius: 6px;
            padding: 4px 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    @include('layouts.header')

    <div class="content-wrapper">
        <a href="{{ route('user.dashboard') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        {{-- Data Tabel On-Going --}}
        <div class = "table-container">
            <h3 class ="heading-section" style="color:#032E3D; font-weight:bold;">Daftar Safety Observation (Sedang
                Diproses)</h3>
            <form method="GET" action="{{ route('user.laporan') }}" style="margin-bottom: 20px;">
                <div class="filter-form-wrapper">
                    <input type="text" id="tanggal_pelaporan" name="tanggal_pelaporan_ongoing" placeholder="Tanggal"
                        class="form-control" value="{{ request('tanggal_pelaporan_ongoing') }}">

                    <input type="text" name="judul_temuan_ongoing" placeholder="Judul Temuan" class="form-control"
                        value="{{ request('judul_temuan_ongoing') }}">

                    <select name="kategori_ongoing" class="form-select">
                        <option value="">Kategori</option>
                        <option value="Unsafe Condition"
                            {{ request('kategori_ongoing') == 'Unsafe Condition' ? 'selected' : '' }}>Unsafe Condition
                        </option>
                        <option value="Unsafe Act" {{ request('kategori_ongoing') == 'Unsafe Act' ? 'selected' : '' }}>
                            Unsafe Act</option>
                    </select>

                    <select name="status_ongoing" class="form-select">
                        <option value="">Status</option>
                        <option value="waiting" {{ request('status_ongoing') == 'waiting' ? 'selected' : '' }}>Waiting
                        </option>
                        <option value="pending" {{ request('status_ongoing') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="on_progress" {{ request('status_ongoing') == 'on_progress' ? 'selected' : '' }}>
                            On Progress</option>
                        <option value="closed" {{ request('status_ongoing') == 'closed' ? 'selected' : '' }}>Closed
                        </option>
                        <option value="open" {{ request('status_ongoing') == 'open' ? 'selected' : '' }}>Open
                        </option>
                    </select>

                    <button type="submit" class="btn btn-primary"
                        style="height: 36px; font-size: 14px; display: flex; align-items: center; gap: 6px; background-color: #032E3D; color: #fff; border: none; border-radius: 6px; padding: 6px 14px;">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pelaporan</th>
                            <th>Judul Temuan</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ongoing as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggal_pelaporan }}</td>
                                <td>{{ $item->judul_temuan }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>
                                    @php
                                        $status = $item->status;
                                        $bgColor = match ($status) {
                                            'waiting' => '#4abcf9',
                                            'pending' => '#dc3545',
                                            'on_progress' => '#ffc107',
                                            'closed' => '#28a745',
                                            'open' => '#0d6efd',
                                            default => '#6c757d',
                                        };
                                        $textColor = in_array($status, ['on_progress', 'pending'])
                                            ? '#000000'
                                            : '#ffffff';
                                        $label = Str::of($status)->replace('_', ' ')->ucfirst();
                                    @endphp
                                    <span
                                        style="background-color: {{ $bgColor }} !important; color: {{ $textColor }} !important; padding: 5px 12px; font-size: 0.85rem; font-weight: 600; border-radius: 10px; display: inline-block; min-width: 90px; text-align: center;">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('user.userdetail', $item->id) }}" class="button-detail">Lihat
                                        Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data observasi.</td>
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

        {{-- Data Tabel History --}}
        <div class="table-container">
            <h3 class="heading-section">Daftar Safety Observation (History) </h3>
            <form method="GET" action="{{ route('user.laporan') }}" style="margin-bottom: 20px;">
                <div class="filter-form-wrapper">
                    <input type="text" id="tanggal_pelaporan" name="tanggal_pelaporan_closed" placeholder="Tanggal"
                        class="form-control" value="{{ request('tanggal_pelaporan_closed') }}">

                    <input type="text" name="judul_temuan_closed" placeholder="Judul Temuan" class="form-control"
                        value="{{ request('judul_temuan_closed') }}">

                    <select name="kategori_closed" class="form-select">
                        <option value="">Kategori</option>
                        <option value="Unsafe Condition"
                            {{ request('kategori_closed') == 'Unsafe Condition' ? 'selected' : '' }}>Unsafe Condition
                        </option>
                        <option value="Unsafe Act" {{ request('kategori_closed') == 'Unsafe Act' ? 'selected' : '' }}>
                            Unsafe Act</option>
                    </select>
                    <button type="submit" class="btn btn-primary"
                        style="height: 36px; font-size: 14px; display: flex; align-items: center; gap: 6px; background-color: #032E3D; color: #fff; border: none; border-radius: 6px; padding: 6px 14px;">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pelaporan</th>
                            <th>Judul Temuan</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($closed as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggal_pelaporan }}</td>
                                <td>{{ $item->judul_temuan }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>
                                    @php
                                        $status = $item->status;
                                        $bgColor = match ($status) {
                                            'waiting' => '#4abcf9',
                                            'pending' => '#dc3545',
                                            'on_progress' => '#ffc107',
                                            'closed' => '#28a745',
                                            'open' => '#0d6efd',
                                            default => '#6c757d',
                                        };
                                        $textColor = in_array($status, ['on_progress', 'pending'])
                                            ? '#000000'
                                            : '#ffffff';
                                        $label = Str::of($status)->replace('_', ' ')->ucfirst();
                                    @endphp
                                    <span
                                        style="background-color: {{ $bgColor }} !important; color: {{ $textColor }} !important; padding: 5px 12px; font-size: 0.85rem; font-weight: 600; border-radius: 10px; display: inline-block; min-width: 90px; text-align: center;">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('user.userdetail', $item->id) }}" class="button-detail">Lihat
                                        Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data observasi.</td>
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

        {{-- Data Tabel History Seksi --}}
        <div class="table-container">
            <h3 class="heading-section">Daftar Safety Observation (History Seksi Saya) </h3>
            <form method="GET" action="{{ route('user.laporan') }}" style="margin-bottom: 20px;">
                <div class="filter-form-wrapper">
                    <input type="text" id="tanggal_pelaporan" name="tanggal_pelaporan_closed"
                        placeholder="Tanggal" class="form-control"
                        value="{{ request('tanggal_pelaporan_closed') }}">

                    <input type="text" name="judul_temuan_closed" placeholder="Judul Temuan" class="form-control"
                        value="{{ request('judul_temuan_closed') }}">

                    <select name="kategori_closed" class="form-select">
                        <option value="">Kategori</option>
                        <option value="Unsafe Condition"
                            {{ request('kategori_closed') == 'Unsafe Condition' ? 'selected' : '' }}>Unsafe Condition
                        </option>
                        <option value="Unsafe Act" {{ request('kategori_closed') == 'Unsafe Act' ? 'selected' : '' }}>
                            Unsafe Act</option>
                    </select>
                    <button type="submit" class="btn btn-primary"
                        style="height: 36px; font-size: 14px; display: flex; align-items: center; gap: 6px; background-color: #032E3D; color: #fff; border: none; border-radius: 6px; padding: 6px 14px;">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pelaporan</th>
                            <th>Nama</th>
                            <th>Judul Temuan</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($terlapor as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggal_pelaporan }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->judul_temuan }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>
                                    @php
                                        $status = $item->status;
                                        $bgColor = match ($status) {
                                            'waiting' => '#4abcf9',
                                            'pending' => '#dc3545',
                                            'on_progress' => '#ffc107',
                                            'closed' => '#28a745',
                                            'open' => '#0d6efd',
                                            default => '#6c757d',
                                        };
                                        $textColor = in_array($status, ['on_progress', 'pending'])
                                            ? '#000000'
                                            : '#ffffff';
                                        $label = Str::of($status)->replace('_', ' ')->ucfirst();
                                    @endphp
                                    <span
                                        style="background-color: {{ $bgColor }} !important; color: {{ $textColor }} !important; padding: 5px 12px; font-size: 0.85rem; font-weight: 600; border-radius: 10px; display: inline-block; min-width: 90px; text-align: center;">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('user.userdetail', $item->id) }}" class="button-detail">Lihat
                                        Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data observasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                    <div class="pagination-info">
                        Menampilkan {{ $terlapor->firstItem() }} – {{ $terlapor->lastItem() }} dari
                        total
                        {{ $terlapor->total() }} data
                    </div>
                    <div class="pagination">
                        {{ $terlapor->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        flatpickr("#tanggal_pelaporan", {
            dateFormat: "Y-m-d",
            allowInput: true
        });
    </script>
</body>

</html>
