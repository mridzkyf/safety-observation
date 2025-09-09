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
    @if ($source === 'terlapor')
        <a href="{{ route('approver.terlapor') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Kembali ke Laporan Terlapor</a>
    @else
        <a href="{{ route('approver.temuan') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Kembali ke Tabel Temuan</a>
    @endif
    <div class="detail-card">
        <div class="detail-title">Detail Laporan #{{ $observation->id }}</div>

        <div class="detail-item"><strong>Nama:</strong> {{ $observation->nama }}</div>
        <div class="detail-item"><strong>Email:</strong> {{ $observation->email }}</div>
        <div class="detail-item"><strong>Nama Seksi:</strong> {{ $observation->nama_seksi }}</div>
        <div class="detail-item"><strong>Group:</strong> {{ $observation->group }}</div>
        <div class="detail-item"><strong>Lokasi Kerja:</strong> {{ $observation->lokasi_kerja }}</div>
        <div class="detail-item"><strong>Tanggal Kejadian:</strong> {{ $observation->tanggal_pelaporan }}</div>
        <div class="detail-item"><strong>Lokasi Observasi:</strong> {{ $observation->lokasi_observasi }}</div>
        <div class="detail-item"><strong>Judul Temuan:</strong> {{ $observation->judul_temuan }}</div>
        <div class="detail-item"><strong>Kategori:</strong> {{ $observation->kategori }}</div>
        <div class="detail-item"><strong>Jenis Temuan:</strong> {{ $observation->jenis_temuan }}</div>

        @if ($observation->jenis_temuan == 'Metode')
            <div class="detail-item"><strong>Detail Metode:</strong> {{ $observation->sub_metode ?? '-' }}</div>
        @elseif ($observation->jenis_temuan == 'Alat/Fasilitas')
            <div class="detail-item"><strong>Detail Alat/Fasilitas:</strong> {{ $observation->sub_alat ?? '-' }}
            </div>
        @elseif ($observation->jenis_temuan == 'APD')
            <div class="detail-item"><strong>Detail APD:</strong> {{ $observation->sub_apd ?? '-' }}</div>
        @elseif ($observation->jenis_temuan == '5S & G7')
            <div class="detail-item"><strong>Detail 5S & G7:</strong> {{ $observation->sub_5s ?? '-' }}</div>
        @elseif ($observation->jenis_temuan == 'Posisi Kerja')
            <div class="detail-item"><strong>Detail Posisi Kerja:</strong> {{ $observation->sub_posisi ?? '-' }}
            </div>
        @endif

        <div class="detail-item"><strong>Situasi / Kejadian:</strong> {{ $observation->situasi }}</div>
        <div class="detail-item"><strong>Tindakan yang Sudah Dilakukan:</strong> {{ $observation->tindakan }}</div>
        <div class="detail-item"><strong>Keterangan Status:</strong> {{ $observation->keterangan_status ?? '-' }}</div>

        {{-- Bukti gambar temuan --}}
        <div class="detail-item"><strong>Bukti Foto Temuan:</strong></div>
        @if ($observation->bukti_gambar)
            <div class="image-preview"> <img src="{{ asset('storage/' . $observation->bukti_gambar) }}"
                    alt="Bukti Gambar" style="max-width: 200px; cursor: pointer;" data-bs-toggle="modal"
                    data-bs-target="#imageModal">
            </div> <!-- Modal -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-body p-0"> <img src="{{ asset('storage/' . $observation->bukti_gambar) }}"
                                class="img-fluid w-100" alt="Full Image"> </div>
                    </div>
                </div>
            </div>
        @else
            <p class="text-muted"><em>Tidak ada gambar</em></p>
        @endif

        {{-- Bukti gambar selesai --}}
        <div class="detail-item"><strong>Bukti Foto Perbaikan:</strong></div>
        @if ($observation->bukti_selesai)
            <div class="image-preview">
                <img src="{{ asset('storage/' . $observation->bukti_selesai) }}" alt="Bukti Selesai"
                    style="max-width: 200px; cursor: pointer;" data-bs-toggle="modal"
                    data-bs-target="#imageModalSelesai">
            </div>

            <!-- Modal Bukti Selesai -->
            <div class="modal fade" id="imageModalSelesai" tabindex="-1" aria-labelledby="imageModalSelesaiLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <img src="{{ asset('storage/' . $observation->bukti_selesai) }}" class="img-fluid w-100"
                                alt="Full Image">
                        </div>
                    </div>
                </div>
            </div>
        @else
            <p class="text-muted"><em>Tidak ada gambar perbaikan</em></p>
        @endif

        {{-- untuk penunjukan SIC --}}
        @if (auth()->user()->role === 'officer' || auth()->user()->role === 'supervisor' || auth()->user()->role === 'manager')
            @if ($observation->status === 'waiting' && !$observation->sic_id)
                <form method="POST" action="{{ route('approver.approve', $observation->id) }}">
                    @csrf
                    <label for="area_id">Pilih Area Tujuan:</label>
                    <select name="area_id" class="form-select" required>
                        <option value="">-- Pilih Area SIC --</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary mt-2">Setujui & Kirim ke SIC Area</button>
                </form>
                {{-- Tombol CLOSE --}}
                <form method="POST" action="{{ route('approver.close', $observation->id) }}" class="mt-2">
                    @csrf
                    <button type="submit" class="btn btn-danger">Tutup Laporan (Close)</button>
                </form>
            @else
                <hr>
                <div class="mt-4 p-3 rounded" style="background-color: #f1f1f1; color: #032E3D;">
                    <h5>Status Laporan</h5>
                    <p>
                        <strong>Status Saat Ini:</strong>
                        @php
                            $label = ucfirst(str_replace('_', ' ', $observation->status));
                            $bgColor = match ($observation->status) {
                                'pending' => '#dc3545',
                                'on_progress' => '#ffc107',
                                'closed' => '#28a745',
                                'open' => '#0d6efd',
                                default => '#6c757d',
                            };
                            $textColor = in_array($observation->status, ['pending', 'on_progress'])
                                ? '#000000'
                                : '#ffffff';
                        @endphp
                        <span
                            style="background-color: {{ $bgColor }}; color: {{ $textColor }}; padding: 6px 14px; border-radius: 8px;">
                            {{ $label }}
                        </span>
                    </p>
                    <p>
                        <strong>SIC Area yang ditunjuk:</strong>
                        @if ($observation->area)
                            {{ $observation->area->name }}
                        @else
                            <em>Belum ditentukan</em>
                        @endif
                    </p>
                </div>
            @endif
        @endif
    </div>
    </div>
</body>

</html>
