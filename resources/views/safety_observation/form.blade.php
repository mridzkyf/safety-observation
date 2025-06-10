<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Safety Observation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .logo-box {
            width: 150px;
            height: 50px;
            background-color: #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
        }
        .form-section {
            padding: 30px;
        }
        .form-header {
            background-color: #0d6efd;
            color: white;
            padding: 20px;
            border-top-left-radius: .5rem;
            border-top-right-radius: .5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .form-header h4 {
            margin: 0;
        }
        .form-group-title {
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body class="bg-light" style="background: linear-gradient(to bottom right, #377637, #ffffff);">
<div class="container mt-5 rounded" style="background:#f6f1f1;">
    <div class="container mt-5 p-4 rounded" style="background:#f6f1f1;">
        <div class="form-header">
            <img src="{{ asset('images/MFI.png') }}" alt="Logo MFI" style="height: 50px;">
            <h4 class="ms-3">Form Safety Observation</h4>
        </div>
        <div class="card-body form-section">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('safety-observation.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Seksi</label>
                    <select name="nama_seksi" class="form-select" required>
                        <option value="">-- Pilih Seksi --</option>
                        @foreach($daftarSeksi as $seksi)
                            <option value="{{ $seksi }}">{{ $seksi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label form-group-title">Group</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="group" value="DAY TIME" class="form-check-input" required>
                        <label class="form-check-label">DAY TIME</label>
                    </div>
                    @foreach(['A', 'B', 'C', 'D'] as $group)
                        <div class="form-check form-check-inline">
                            <input type="radio" name="group" value="GROUP {{ $group }}" class="form-check-input">
                            <label class="form-check-label">GROUP {{ $group }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <label class="form-label form-group-title">Lokasi Kerja</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="lokasi_kerja" value="FAM" class="form-check-input" required>
                        <label class="form-check-label">FAM</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="lokasi_kerja" value="SQ" class="form-check-input">
                        <label class="form-check-label">SQ</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Pelaporan</label>
                        <input type="date" name="tanggal_pelaporan" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lokasi Observasi</label>
                        <input type="text" name="lokasi_observasi" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Temuan</label>
                    <input type="text" name="judul_temuan" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label form-group-title">Kategori</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="kategori" value="Unsafe Act" class="form-check-input" required>
                        <label class="form-check-label">Tindakan tidak aman (UA)</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="kategori" value="Unsafe Condition" class="form-check-input">
                        <label class="form-check-label">Kondisi tidak aman (UC)</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label form-group-title">Jenis Temuan</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="jenis_temuan" value="Metode" class="form-check-input" required>
                        <label class="form-check-label">Metode</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="jenis_temuan" value="Alat/Fasilitas" class="form-check-input">
                        <label class="form-check-label">Alat/Fasilitas</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label form-group-title">Metode</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="metode" value="Metode kerja tidak mencukupi" class="form-check-input" required>
                        <label class="form-check-label">Metode kerja tidak mencukupi</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="metode" value="Metode kerja tidak dimengerti" class="form-check-input">
                        <label class="form-check-label">Metode kerja tidak dimengerti</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label form-group-title">Alat / Fasilitas</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="alat_fasilitas" value="PPE" class="form-check-input" required>
                        <label class="form-check-label">PPE</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="alat_fasilitas" value="Mesin" class="form-check-input">
                        <label class="form-check-label">Mesin</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Bukti Gambar</label>
                    <input type="file" name="bukti_gambar" class="form-control" accept=".jpeg,.jpg,.png">
                </div>

                <button type="submit" class="btn btn-success">Kirim Laporan</button>
            </form>
        </div>
    </div>
</div>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const fileInput = form.querySelector('input[type="file"][name="bukti_gambar"]');
    let isFormDirty = false;
    let isSubmitting = false;

    // Tandai form sudah diubah
    form.querySelectorAll("input, select, textarea").forEach(input => {
        input.addEventListener("input", () => {
            isFormDirty = true;
        });
    });

    // Saat submit, tandai form sedang submit
    form.addEventListener("submit", function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
            Swal.fire({
                icon: 'warning',
                title: 'Form / Foto Belum Lengkap!',
                text: 'Silakan isi semua kolom yang wajib diisi.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#198754'
            });
            return;
        }
        if (fileInput.files.length === 0) {
            e.preventDefault();
            e.stopPropagation();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Bukti Foto belum terunggah!',
            });
            return;
        }
        isSubmitting = true; // tandai submit agar sebelumunload tidak aktif
    });

    // beforeunload hanya bisa pakai alert bawaan
    window.addEventListener("beforeunload", function(e) {
        if (isFormDirty && !isSubmitting) {
            e.preventDefault();
            e.returnValue = ''; // Ini wajib supaya muncul alert konfirmasi refresh/tab close
        }
    });
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        confirmButtonColor: '#198754'
    }).then(() => {
        // Hapus efek flash supaya tidak muncul lagi saat refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    });
    @endif
});
</script>

</body>
</html>