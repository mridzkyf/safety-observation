@php
    $brandColor = '#78C841'; // warna brand MFI
    $muted = '#6c757d';
@endphp
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Status SO Diperbarui</title>
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
                <table class="container" cellpadding="0" cellspacing="0" width="600"
                    style="background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.04);">
                    <!-- Header -->
                    <tr>
                        <td
                            style="background:{{ $brandColor }};padding:16px 24px;color:#fff;font:bold 16px system-ui;">
                            Safety Observation PT MC PET FILM INDONESIA
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td class="p-24" style="padding:24px;">
                            <div style="font:700 20px system-ui;color:#1b1f24;margin-bottom:12px;">
                                Status SO Anda Telah Diperbarui
                            </div>
                            <p style="font:400 14px/1.6 system-ui;color:#111;">
                                Laporan Safety Observation yang Anda buat mengalami perubahan status dari
                                <b>{{ $oldStatus }}</b> menjadi <b>{{ $newStatus }}</b>.
                            </p>

                            <table cellpadding="0" cellspacing="0" width="100%"
                                style="border-collapse:separate;border-spacing:0 8px;">
                                <tr>
                                    <td style="width:160px;color:{{ $muted }};font:600 13px;">Judul</td>
                                    <td style="font:500 14px;color:#111;">{{ $so->judul_temuan ?? $so->judul }}</td>
                                </tr>
                                <tr>
                                    <td style="color:{{ $muted }};font:600 13px;">Kategori</td>
                                    <td>{{ $so->kategori }}</td>
                                </tr>
                                <tr>
                                    <td style="color:{{ $muted }};font:600 13px;">Lokasi</td>
                                    <td>{{ $so->lokasi_observasi }}</td>
                                </tr>
                                <tr>
                                    <td style="color:{{ $muted }};font:600 13px;">Seksi</td>
                                    <td>{{ $so->nama_seksi }}</td>
                                </tr>
                                @if (!empty($note))
                                    <tr>
                                        <td style="color:{{ $muted }};font:600 13px;vertical-align:top;">Catatan
                                        </td>
                                        <td>{{ $note }}</td>
                                    </tr>
                                @endif
                            </table>

                            <div style="margin:24px 0 0 0;">
                                <a class="btn" href="{{ url('/so/' . $so->id) }}"
                                    style="background:{{ $brandColor }};color:#fff;text-decoration:none;padding:12px 18px;border-radius:10px;font:600 14px;">
                                    Lihat Detail SO
                                </a>
                            </div>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="padding:16px 24px;color:{{ $muted }};font:400 12px;">
                            Email ini dikirim otomatis oleh sistem Safety Observation. Mohon tidak membalas email ini.
                            <br>© {{ date('Y') }} PT MC PET FILM INDONESIA
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
