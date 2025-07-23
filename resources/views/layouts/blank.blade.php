<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Tambahkan link CSS custom jika perlu --}}
    <link rel="stylesheet" href="{{ asset('argon/css/dashboard-custom.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- jika pakai Vite --}}
</head>

<body class="bg-light">

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')

</body>

</html>
