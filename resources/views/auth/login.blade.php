<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../argon/img/MFI.png">
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Tambahkan SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('argon/css/argon-dashboard.css') }}" rel="stylesheet" />
</head>

<body class="">
    <main class="main-content  mt-0">
        <section class="d-flex align-items-center justify-content-center min-vh-100">
            <div class="text-center">
                <!-- Logo + Tulisan Welcome -->
                <img src="{{ asset('argon/img/MFI.png') }}" alt="Logo MFI" style="height: 90px; margin-bottom: 40px;">
                <div style="font-size: 1rem; font-weight: 900; line-height: 1.3; margin-bottom: 20px;">
                    Selamat datang di<br>
                    Safety Observation System PT. MC PET FILM INDONESIA
                </div>

                <!-- Card Login Form -->
                <div class="card card-plain mx-auto" style="max-width: 420px;">
                    <div class="card-header pb-0 text-start">
                        <h4 class="font-weight-bolder text-center">Sign In</h4>
                        <p class="mb-0 text-center">Masukkan Email dan Password</p>
                    </div>
                    <div class="card-body">
                        <form role="form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control form-control-lg"
                                    placeholder="Email" aria-label="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control form-control-lg"
                                    placeholder="Password" aria-label="Password" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-lg btn-primary w-100 mt-4 mb-0">Sign in</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center pt-0 px-lg-2 px-1">
                        <p class="mb-4 text-sm mx-auto">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-primary text-gradient font-weight-bold">Sign
                                up</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/argon-dashboard.min.js?v=2.1.0"></script>
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '{{ session('error') }}',
                confirmButtonColor: '#3085d6',
            });
        </script>
    @endif
</body>

</html>
