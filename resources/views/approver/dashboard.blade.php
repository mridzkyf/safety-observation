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
            <h4>Approval Safety Observation List</h4>
            <a href="{{ route('approver.temuan') }}" class="dashboard-button">
                Lihat data SO <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        {{-- card 5 --}}
        <div class="dashboard-card">
            <img src="{{ asset('argon/img/alert.png') }}" alt="Analysis Icon">
            <h4>List Laporan Divisi</h4>
            <a href="{{ route('approver.terlapor') }}" class="dashboard-button">
                Lihat Laporan <i class="fas fa-arrow-right"></i>
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
