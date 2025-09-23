<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Setting Poster</title>
    <link rel="stylesheet" href="{{ asset('argon/css/dashboard-custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

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

    .poster-preview {
        border: 2px dashed #032E3D;
        border-radius: 12px;
        max-width: 500px;
        width: 100%;
        margin: 0 auto 20px auto;
        padding: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 350px;
        background-color: #f9f9f9;
    }

    .poster-preview img {
        max-width: 100%;
        max-height: 330px;
        object-fit: contain;
        border-radius: 8px;
    }
</style>

<body>
    @include('layouts.header')
    <div class='content-wrapper'>
        <a href="{{ route('admin.dashboard') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        <div class='table-container'>
            <h3 style="color:#032E3D; font-weight:bold;">Setting Poster (Landing Page Login)</h3>
            <div class="text-center mb-4">
                <div class="poster-preview d-flex justify-content-center align-items-center mb-3">
                    @if ($poster && $poster->file_path)
                        <img src="{{ asset('storage/' . $poster->file_path) }}" alt="Poster">
                    @else
                        <p class="text-muted m-0"><em>Belum ada poster yang diunggah.</em></p>
                    @endif
                </div>

                <div class="d-flex flex-column align-items-center mt-3" style="max-width: 400px; margin:0 auto;">
                    <!-- Input file -->
                    <form id="formUpdatePoster" action="{{ route('admin.poster.update') }}" method="POST"
                        enctype="multipart/form-data" class="w-100">
                        @csrf
                        @method('PUT')
                        <input type="file" name="poster" accept="image/*" class="form-control mb-3" required>
                    </form>

                    <!-- Tombol sejajar -->
                    <div class="d-flex justify-content-between gap-2 w-100">
                        <!-- Tombol Ganti Poster (submit form update) -->
                        <button type="submit" form="formUpdatePoster" class="btn btn-primary flex-fill">Ganti
                            Poster</button>

                        <!-- Tombol Hapus Poster -->
                        @if ($poster && $poster->file_path)
                            <form action="{{ route('admin.poster.destroy') }}" method="POST" class="flex-fill"
                                onsubmit="return confirm('Yakin ingin menghapus poster?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id = "btnDeletePoster" class="btn btn-danger w-100">Hapus
                                    Poster</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- Tambahkan SweetAlert -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const btnDelete = document.getElementById("btnDeletePoster");
        if (btnDelete) {
            btnDelete.addEventListener("click", function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Yakin hapus poster?",
                    text: "Poster yang dihapus tidak bisa dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("formDeletePoster").submit();
                    }
                });
            });
        }
    });
</script>

</html>
