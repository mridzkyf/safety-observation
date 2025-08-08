<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('argon/css/dashboard-custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <!-- Header -->

    @include('layouts.header')
    <!-- Content -->
    <div class="dashboard-container">
        <!-- Card 1 -->
        <div class="dashboard-card">
            <img src="{{ asset('argon/img/FORM.png') }}" alt="Form Icon">
            <h4>Safety Observation Form</h4>
            <a href="{{ route('safety-observation.form') }}" class="dashboard-button">
                Isi Form <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Card 2 -->
        <div class="dashboard-card">
            <img src="{{ asset('argon/img/TABEL.png') }}" alt="Table Icon">
            <h4>Tabel Temuan</h4>
            <a href="{{ route('admin.tabel') }}" class="dashboard-button">
                Buka Tabel <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Card 3 -->
        <div class="dashboard-card">
            <img src="{{ asset('argon/img/ANALISIS.png') }}" alt="Analysis Icon">
            <h4>Analisis Temuan</h4>
            <a href="{{ route('analisis.pie') }}" class="dashboard-button">
                Buka Analisis <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        {{-- card 4 --}}
        <div class="dashboard-card">
            <img src="{{ asset('argon/img/users.png') }}" alt="Analysis Icon">
            <h4>Kelola User</h4>
            <a href="{{ route('admin.users.dashusers') }}" class="dashboard-button">
                Kelola User <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        {{-- card 5 --}}
        <div class="dashboard-card">
            <img src="{{ asset('argon/img/MSDS.png') }}" alt="Analysis Icon">
            <h4>Material Safety DataSheet</h4>
            <a href="#" class="dashboard-button disabled">
                Buka MSDS <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    {{-- <script>
        function toggleDropdown() {
            const menu = document.getElementById('dropdown-menu');
            menu.classList.toggle('hidden');
        }
    </script> --}}

</body>

</html>
