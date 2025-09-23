<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Safety Observation')</title>
    <link rel="stylesheet" href="{{ asset('argon/css/dashboard-custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard-header {
            background-color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .dashboard-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dashboard-logo img {
            height: 40px;
        }

        .dashboard-logo span {
            font-weight: bold;
            font-size: 18px;
            color: #032E3D;
        }

        .burger-menu {
            font-size: 20px;
            cursor: pointer;
            color: #032E3D;
        }

        .dropdown-menu {
            position: absolute;
            top: 70px;
            right: 30px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px;
            display: none;
            flex-direction: column;
            min-width: 150px;
            z-index: 1000;
        }

        .dropdown-menu.show {
            display: flex;
        }

        .dropdown-menu a,
        .dropdown-menu button {
            padding: 8px 12px;
            text-align: left;
            text-decoration: none;
            color: #032E3D;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
        }

        .dropdown-menu a:hover,
        .dropdown-menu button:hover {
            background-color: #f2f2f2;
        }

        body {
            background-color: #032E3D;
            margin: 0;
            font-family: 'Open Sans', sans-serif;
        }

        main {
            padding: 30px;
        }
    </style>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="dashboard-header">
        <div class="dashboard-logo"> <img src="{{ asset('argon/img/MFI.png') }}" alt="Logo MFI" /> <span>SHE
                Digitalization System</span> </div>
        @if (auth()->check())
            <div style="color: rgb(12, 0, 0); padding: 10px 30px; font-weight: 600;">
                Selamat datang, {{ auth()->user()->name }} dari {{ auth()->user()->role }} seksi
                {{ auth()->user()->nama_seksi }}
            </div>
            <div class="burger-menu" onclick="toggleDropdown()"> <i class="fas fa-bars"></i> </div>
            <div id="dropdown-menu" class="dropdown-menu"> <a href="{{ route('profile.edit') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}"> @csrf <button type="submit">Logout</button>
                </form>
            </div>
    </div>
    @endif
    <main>
        @yield('content')
    </main>

    <script>
        function toggleDropdown() {
            const menu = document.getElementById("dropdown-menu");
            menu.classList.toggle("show");
        }
        document.addEventListener("click", function(event) {
            const menu = document.getElementById("dropdown-menu");
            const burger = document.querySelector(".burger-menu");
            if (!menu.contains(event.target) && !burger.contains(event.target)) {
                menu.classList.remove("show");
            }
        });
    </script>
</body>

</html>
