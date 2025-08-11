@component('mail::message')
    # {{ $x['headline'] ?? 'Notifikasi SO' }}

    **Judul:** {{ $so->judul }}
    **Kategori:** {{ $so->kategori }}
    **Lokasi:** {{ $so->lokasi_observasi }}
    **Status:** {{ strtoupper($so->status) }}

    @if (!empty($x['message']))
        {{ $x['message'] }}
    @endif

    @component('mail::button', ['url' => $x['cta_url'] ?? url('/so/' . $so->id)])
        {{ $x['cta_text'] ?? 'Lihat Detail' }}
    @endcomponent

    Terima kasih,
    {{ config('app.name') }}
@endcomponent
