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
        <div class="dashboard-card">
            <img src="{{ asset('argon/img/TABEL.png') }}" alt="Form Icon">
            <h4>Riwayat Safety Observation</h4>
            <a href="{{ route('user.laporan') }}" class="dashboard-button">
                Lihat Riwayat <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        {{-- card 5 --}}
        <div class="dashboard-card">
            <img src="{{ asset('argon/img/MSDS.png') }}" alt="Analysis Icon">
            <h4>Material Safety DataSheet</h4>
            <a href="http://103.82.240.176:8080/" class="dashboard-button">
                Buka MSDS <i class="fas fa-arrow-right"></i>
            </a>
        </div>
</body>

</html>
