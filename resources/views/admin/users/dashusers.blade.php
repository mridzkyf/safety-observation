<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('argon/css/dashboard-custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #0098be;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
        }

        .content-wrapper {
            padding: 40px;
        }
    </style>
</head>

<body>

    <!-- Header -->

    @include('layouts.header')
    <!-- Content -->
    <div class = "content-wrapper">
        <a href="{{ route('admin.dashboard') }}" class="back-button"><i class="fas fa-arrow-left"></i> Kembali ke
            Dashboard</a>
        <div class="dashboard-container">
            <!-- Card 1 -->
            <div class="dashboard-card">
                <img src="{{ asset('argon/img/listuser.png') }}" alt="Form Icon">
                <h4>List User</h4>
                <a href="{{ route('admin.users.tabeluser') }}" class="dashboard-button">
                    Lihat User <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <!-- Card 2 -->
            <div class="dashboard-card">
                <img src="{{ asset('argon/img/adduser.png') }}" alt="Table Icon">
                <h4>Tambah User</h4>
                <a href="{{ route('admin.users.create') }}" class="dashboard-button">
                    Isi user <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <!-- Card 3 -->
            <div class="dashboard-card">
                <img src="{{ asset('argon/img/AREA.png') }}" alt="Table Icon">
                <h4>Kelola SIC Area</h4>
                <a href="{{ route('admin.area.index') }}" class="dashboard-button">
                    Atur SIC Area <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            {{-- <script>
        function toggleDropdown() {
            const menu = document.getElementById('dropdown-menu');
            menu.classList.toggle('hidden');
        }
    </script> --}}
        </div>


</body>

</html>
