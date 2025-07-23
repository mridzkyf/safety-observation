<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../argon/img/MFI.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link id="pagestyle" href="{{ asset('argon/css/argon-dashboard.css') }}" rel="stylesheet" />
</head>

<body class="">
    <main class="main-content mt-0">
        <section class="d-flex align-items-center justify-content-center min-vh-100">
            <div class="text-center">
                <img src="{{ asset('argon/img/MFI.png') }}" alt="Logo MFI" style="height: 90px; margin-bottom: 40px;">
                <div style="font-size: 1rem; font-weight: 900; line-height: 1.3; margin-bottom: 20px;">
                    Selamat datang di<br>
                    Safety Observation System PT. MC PET FILM INDONESIA
                </div>

                <div class="card card-plain mx-auto" style="max-width: 460px;">
                    <div class="card-header pb-0 text-start">
                        <h4 class="font-weight-bolder text-center">Sign Up</h4>
                        <p class="mb-0 text-center">Silakan isi data registrasi</p>
                    </div>
                    <div class="card-body">
                        <form role="form" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control form-control-lg"
                                    placeholder="Nama Lengkap" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control form-control-lg"
                                    placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control form-control-lg"
                                    placeholder="Password" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password_confirmation" class="form-control form-control-lg"
                                    placeholder="Konfirmasi Password" required>
                            </div>
                            <div class="mb-3">
                                <select name="nama_seksi" class="form-select form-control-lg" required>
                                    <option value="">-- Pilih Nama Seksi --</option>
                                    <option value="ADM">ADM</option>
                                    <option value="Account & Tax">Account & Tax</option>
                                    <option value="CA">CA</option>
                                    <option value="EI">EI</option>
                                    <option value="ENG PET">ENG PET</option>
                                    <option value="FT">FT</option>
                                    <option value="IFB">IFB</option>
                                    <option value="IFC">IFC</option>
                                    <option value="IT">IT</option>
                                    <option value="KTF">KTF</option>
                                    <option value="LOG">LOG</option>
                                    <option value="MC">MC</option>
                                    <option value="MFG PET">MFG PET</option>
                                    <option value="MKF PF">MKF PF</option>
                                    <option value="Material Purchasing">Material Purchasing</option>
                                    <option value="QA & CTS KTF - PF">QA & CTS KTF - PF</option>
                                    <option value="QC KTF - PF">QC KTF - PF</option>
                                    <option value="QQC PET">QQC PET</option>
                                    <option value="SHE">SHE</option>
                                    <option value="TC">TC</option>
                                    <!-- tambahkan seksi lainnya -->
                                </select>
                            </div>
                            <div class="mb-3 text-start">
                                <label class="form-label">Group:</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="group" value="DAY TIME"
                                        required>
                                    <label class="form-check-label">DAY TIME</label>
                                </div>
                                @foreach (['A', 'B', 'C', 'D'] as $gr)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="group"
                                            value="GROUP {{ $gr }}">
                                        <label class="form-check-label">GROUP {{ $gr }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-lg btn-primary w-100 mt-4 mb-0">Sign Up</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center pt-0 px-lg-2 px-1">
                        <p class="mb-4 text-sm mx-auto">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-primary text-gradient font-weight-bold">Sign
                                in</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), {
                damping: '0.5'
            });
        }
    </script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="../assets/js/argon-dashboard.min.js?v=2.1.0"></script>
</body>

</html>
