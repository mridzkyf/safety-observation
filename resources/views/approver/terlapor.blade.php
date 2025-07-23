<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Temuan</title>
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

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #0098be;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
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
            </div>
        </div>

        <!-- Bagian 2: Closed -->
        <div class="table-container">
            <h3 style="color:#032E3D; font-weight:bold; margin-bottom:20px;">Riwayat Safety Observation
            </h3>
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
            </div>
        </div>

    </div>
</body>

</html>
