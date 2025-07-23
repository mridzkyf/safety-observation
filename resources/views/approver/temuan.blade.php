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
        <a href="{{ route('approver.dashboard') }}" class="back-button"><i class="fas fa-arrow-left"></i> Kembali ke
            Dashboard</a>

        <div class="table-container">
            <h3 style="color:#032E3D; font-weight:bold; margin-bottom:20px;">Daftar Safety Observation</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal Pelaporan</th>
                            <th>Nama Pelapor</th>
                            <th>Email</th>
                            <th>Kategori</th>
                            <th>Judul Temuan</th>
                            <th>Lokasi Observasi</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($observations as $item)
                            <tr>
                                <td>{{ $item->tanggal_pelaporan }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>{{ $item->judul_temuan }}</td>
                                <td>{{ $item->lokasi_observasi }}</td>
                                <td>
                                    @php
                                        $status = $item->status;
                                        $bgColor = match ($status) {
                                            'waiting' => '#4abcf9', //biru tua
                                            'pending' => '#dc3545', // Merah
                                            'on_progress' => '#ffc107', // Kuning
                                            'closed' => '#28a745', // Hijau
                                            'open' => '#0d6efd', // Biru
                                            default => '#6c757d', // Abu-abu
                                        };
                                        $textColor = in_array($status, ['on_progress', 'pending'])
                                            ? '#000000'
                                            : '#ffffff';
                                        $label = Str::of($status)->replace('_', ' ')->ucfirst();
                                    @endphp

                                    <span
                                        style="
                                            background-color: {{ $bgColor }} !important;
                                            color: {{ $textColor }} !important;
                                            padding: 5px 12px;
                                            font-size: 0.85rem;
                                            font-weight: 600;
                                            border-radius: 10px;
                                            display: inline-block;
                                            min-width: 90px;
                                            text-align: center;
                                            ">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('approver.temuan.detail', ['id' => $item->id, 'source' => 'temuan']) }}"
                                        class="btn btn-primary">Lihat
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
            </div>
        </div>
    </div>

</body>

</html>
