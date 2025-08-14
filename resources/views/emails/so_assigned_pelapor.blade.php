@php
    $brandColor = '#FFCC00'; // warna brand MFI
    $muted = '#6c757d';
    $statusTxt = strtoupper($so->status ?? 'OPEN');
@endphp
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>SO Anda Sedang Diproses</title>
    <style>
        @media (max-width: 600px) {
            .container {
                width: 100% !important;
            }

            .p-24 {
                padding: 16px !important;
            }

            .btn {
                display: block !important;
                width: 100% !important;
            }
        }
    </style>
</head>

<body style="margin:0;background:#f5f7fb;">
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding:24px;">
                <table class="container" role="presentation" cellpadding="0" cellspacing="0" width="600"
                    style="width:600px;max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.04);">
                    <!-- Header -->
                    <tr>
                        <td style="background:{{ $brandColor }};padding:16px 24px;">
                            <table width="100%">
                                <tr>
                                    <td align="left"
                                        style="color:#fff;font:bold 16px/1.2 system-ui,Segoe UI,Roboto,Arial;">
                                        Safety Observation PT MC PET FILM INDONESIA
                                    </td>
                                    <td align="right">
                                        <img src="{{ asset('argon/img/logosolidmfi.png') }}" alt="Logo"
                                            width="120" style="display:block;border:0;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class="p-24" style="padding:24px 24px 8px 24px;">
                            <div
                                style="font:700 20px/1.3 system-ui,Segoe UI,Roboto,Arial;color:#1b1f24;margin-bottom:12px;">
                                SO Anda Sedang Diproses oleh SIC Area
                            </div>

                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%"
                                style="border-collapse:separate;border-spacing:0 8px;">
                                <tr>
                                    <td style="width:160px;color:{{ $muted }};font:600 13px/1.4 system-ui;">Judul
                                    </td>
                                    <td style="font:500 14px/1.5 system-ui;color:#111;">
                                        {{ $so->judul_temuan ?? $so->judul }}</td>
                                </tr>
                                <tr>
                                    <td style="color:{{ $muted }};font:600 13px/1.4 system-ui;">Kategori</td>
                                    <td style="font:500 14px/1.5 system-ui;color:#111;">{{ $so->kategori }}</td>
                                </tr>
                                <tr>
                                    <td style="color:{{ $muted }};font:600 13px/1.4 system-ui;">Lokasi</td>
                                    <td style="font:500 14px/1.5 system-ui;color:#111;">{{ $so->lokasi_observasi }}</td>
                                </tr>
                                <tr>
                                    <td style="color:{{ $muted }};font:600 13px/1.4 system-ui;">Seksi</td>
                                    <td style="font:500 14px/1.5 system-ui;color:#111;">{{ $so->nama_seksi }}</td>
                                </tr>
                                <tr>
                                    <td style="color:{{ $muted }};font:600 13px/1.4 system-ui;">Area (SIC)</td>
                                    <td style="font:500 14px/1.5 system-ui;color:#111;">
                                        {{ optional($so->area)->nama ?? $so->area_id }}</td>
                                </tr>
                                <tr>
                                    <td style="color:{{ $muted }};font:600 13px/1.4 system-ui;">Status</td>
                                    <td>
                                        <span
                                            style="font:700 12px/1.2 system-ui;color:#084298;background:#e7f1ff;display:inline-block;padding:6px 10px;border-radius:999px;text-transform:uppercase;">
                                            {{ $statusTxt }}
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:16px 0 0 0;font:400 14px/1.6 system-ui;color:#111;">
                                Laporan Anda telah di‑open dan ditunjuk ke tim SIC area terkait. Silakan pantau progres
                                di sistem.
                            </p>

                            <!-- CTA -->
                            <div style="margin:24px 0 0 0;">
                                <a class="btn" href="{{ url('/so/' . $so->id) }}"
                                    style="background:{{ $brandColor }};color:#fff;text-decoration:none;padding:12px 18px;border-radius:10px;font:600 14px/1 system-ui;display:inline-block;">
                                    Lihat Status SO
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:16px 24px 24px 24px;">
                            <div
                                style="border-top:1px solid #eef1f6;padding-top:12px;color:{{ $muted }};font:400 12px/1.6 system-ui;">
                                Email ini dikirim otomatis oleh sistem Safety Observation. Mohon tidak membalas email
                                ini.
                                <br>© {{ date('Y') }} PT MC PET FILM INDONESIA
                            </div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
