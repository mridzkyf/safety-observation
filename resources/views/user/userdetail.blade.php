<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Laporan</title>
    <link rel="stylesheet" href="{{ asset('argon/css/dashboard-custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS (pastikan di head) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS + Popper (sebelum </body>) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #032E3D;
            color: #fff;
        }

        .content-wrapper {
            padding: 40px;
        }

        .detail-card {
            background-color: white;
            color: #032E3D;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .detail-title {
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 1.4rem;
        }

        .detail-item {
            margin-bottom: 15px;
        }

        .detail-item strong {
            display: inline-block;
            width: 200px;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #0A2B33;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #145c73;
        }

        .image-preview {
            margin-top: 15px;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 400px;
            border-radius: 12px;
            cursor: pointer;
        }

        .text-muted {
            color: #6c757d !important;
        }
    </style>
</head>

<body>
    @include('layouts.header')
    <div class="content-wrapper"> <a href="{{ route('user.laporan') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Kembali ke Tabel Data</a>
        <div class="detail-card">
            <div class="detail-title">Detail Laporan #{{ $item->id }}</div>

            <div class="detail-item"><strong>Nama:</strong> {{ $item->nama }}</div>
            <div class="detail-item"><strong>Email:</strong> {{ $item->email }}</div>
            <div class="detail-item"><strong>Nama Seksi:</strong> {{ $item->nama_seksi }}</div>
            <div class="detail-item"><strong>Group:</strong> {{ $item->group }}</div>
            <div class="detail-item"><strong>Lokasi Kerja:</strong> {{ $item->lokasi_kerja }}</div>
            <div class="detail-item"><strong>Tanggal Kejadian:</strong> {{ $item->tanggal_pelaporan }}</div>
            <div class="detail-item"><strong>Lokasi Observasi:</strong> {{ $item->lokasi_observasi }}</div>
            <div class="detail-item"><strong>Judul Temuan:</strong> {{ $item->judul_temuan }}</div>
            <div class="detail-item"><strong>Kategori:</strong> {{ $item->kategori }}</div>
            <div class="detail-item"><strong>Jenis Temuan:</strong> {{ $item->jenis_temuan }}</div>

            @if ($item->jenis_temuan == 'Metode')
                <div class="detail-item"><strong>Detail Metode:</strong> {{ $item->sub_metode ?? '-' }}</div>
            @elseif ($item->jenis_temuan == 'Alat/Fasilitas')
                <div class="detail-item"><strong>Detail Alat/Fasilitas:</strong> {{ $item->sub_alat ?? '-' }}</div>
            @elseif ($item->jenis_temuan == 'APD')
                <div class="detail-item"><strong>Detail APD:</strong> {{ $item->sub_apd ?? '-' }}</div>
            @elseif ($item->jenis_temuan == '5S & G7')
                <div class="detail-item"><strong>Detail 5S & G7:</strong> {{ $item->sub_5s ?? '-' }}</div>
            @elseif ($item->jenis_temuan == 'Posisi Kerja')
                <div class="detail-item"><strong>Detail Posisi Kerja:</strong> {{ $item->sub_posisi ?? '-' }}</div>
            @endif

            <div class="detail-item"><strong>Situasi / Kejadian:</strong> {{ $item->situasi }}</div>
            <div class="detail-item"><strong>Tindakan yang Sudah Dilakukan:</strong> {{ $item->tindakan }}</div>

            <div class="detail-item"><strong>Bukti Foto Temuan:</strong></div>
            @if ($item->bukti_gambar)
                <div class="image-preview"> <img src="{{ asset('storage/' . $item->bukti_gambar) }}" alt="Bukti Gambar"
                        style="max-width: 200px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal">
                </div> <!-- Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-body p-0"> <img src="{{ asset('storage/' . $item->bukti_gambar) }}"
                                    class="img-fluid w-100" alt="Full Image"> </div>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-muted"><em>Tidak ada gambar</em></p>
            @endif
            <hr>
            <div class="mt-4 p-3 rounded" style="background-color: #f1f1f1; color: #032E3D;">
                <h5>Status Laporan</h5>
                <p>
                    <strong>Status Saat Ini:</strong>
                    @php
                        $label = ucfirst(str_replace('_', ' ', $item->status));
                        $bgColor = match ($item->status) {
                            'pending' => '#dc3545',
                            'on_progress' => '#ffc107',
                            'closed' => '#28a745',
                            'open' => '#0d6efd',
                            default => '#6c757d',
                        };
                        $textColor = in_array($item->status, ['pending', 'on_progress']) ? '#000000' : '#ffffff';
                    @endphp
                    <span
                        style="background-color: {{ $bgColor }}; color: {{ $textColor }}; padding: 6px 14px; border-radius: 8px;">
                        {{ $label }}
                    </span>
                </p>
                <p>
                    <strong>SIC Area yang ditunjuk:</strong>
                    @if ($item->area)
                        {{ $item->area->name }}
                    @else
                        <em>Belum ditentukan</em>
                    @endif
                </p>
            </div>
        </div>
    </div>
</body>

</html>
