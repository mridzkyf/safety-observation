@extends('layouts.blank')

@section('content')
    @include('layouts.header')
    <div class="container py-5">
        <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('user.dashboard') }}"
            class="btn btn-dark mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        <div class="card shadow p-4" style="border-radius: 16px;">
            <h4 class="mb-4 text-primary">Form Safety Observation</h4>

            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: @json(session('success')),
                            confirmButtonColor: '#3085d6'
                        });
                    });
                </script>
            @endif

            @php
                $jenisMap = [
                    'Metode' => 'metode',
                    'Alat/Fasilitas' => 'alat',
                    'APD' => 'apd',
                    '5S & G7' => '5s',
                    'Posisi Kerja' => 'posisi',
                ];
            @endphp

            @if ($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Form Belum Lengkap',
                            html: `{!! implode('<br>', $errors->all()) !!}`,
                            confirmButtonColor: '#d33'
                        });
                    });
                </script>
            @endif

            @if (old('jenis_temuan'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showSubSection('{{ $jenisMap[old('jenis_temuan')] ?? '' }}');
                    });
                </script>
            @endif

            <form id="observationForm" action="{{ route('safety-observation.store') }}" method="POST"
                enctype="multipart/form-data" novalidate>
                @csrf

                {{-- Baris 1 --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>Nama</strong></label>
                        <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                        <input type="hidden" name="nama" value="{{ $user->name }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" disabled>
                        <input type="hidden" name="email" value="{{ $user->email }}">
                    </div>
                </div>

                {{-- Nama Seksi --}}
                <div class="mb-3">
                    <label class="form-label">Nama Seksi</label>
                    <select class="form-select" disabled>
                        <option selected>{{ $user->nama_seksi }}</option>
                    </select>
                    <input type="hidden" name="nama_seksi" value="{{ $user->nama_seksi }}">

                </div>

                {{-- Group --}}
                <div class="mb-3">
                    <label class="form-label d-block">Group</label>
                    <input type="text" class="form-control" value="{{ $user->group }}" disabled>
                    <input type="hidden" name="group" value="{{ $user->group }}">
                </div>

                {{-- Lokasi Kerja --}}
                <div class="mb-3">
                    <label class="form-label d-block">Lokasi Kerja</label>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="form-check">
                            <input type="radio" name="lokasi_kerja" value="FAM" class="form-check-input"
                                {{ old('lokasi_kerja') == 'FAM' ? 'checked' : '' }} required>
                            <label class="form-check-label">FAM</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="lokasi_kerja" value="SQ" class="form-check-input"
                                {{ old('lokasi_kerja') == 'SQ' ? 'checked' : '' }} required>
                            <label class="form-check-label">SQ</label>
                        </div>
                    </div>
                </div>

                {{-- Baris 2 --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Pelaporan</label>
                        <input type="date" name="tanggal_pelaporan" class="form-control"
                            value="{{ old('tanggal_pelaporan') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lokasi Observasi</label>
                        <input type="text" name="lokasi_observasi" class="form-control"
                            value="{{ old('lokasi_observasi') }}" required>
                    </div>
                </div>

                {{-- Judul Temuan --}}
                <div class="mb-3">
                    <label class="form-label">Judul Temuan</label>
                    <input type="text" name="judul_temuan" class="form-control" value="{{ old('judul_temuan') }}"
                        required>
                </div>

                {{-- Kategori --}}
                <div class="mb-3">
                    <label class="form-label d-block">Kategori</label>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="form-check">
                            <input type="radio" name="kategori" value="Unsafe Act" class="form-check-input"
                                {{ old('kategori') == 'Unsafe Act' ? 'checked' : '' }} required>
                            <label class="form-check-label">Tindakan tidak aman (UA)</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="kategori" value="Unsafe Condition" class="form-check-input"
                                {{ old('kategori') == 'Unsafe Condition' ? 'checked' : '' }}>
                            <label class="form-check-label">Kondisi tidak aman (UC)</label>
                        </div>
                    </div>
                </div>


                {{-- Jenis Temuan --}}
                <div class="mb-3">
                    <label class="form-label d-block">Jenis Temuan</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach (['Metode', 'Alat/Fasilitas', 'APD', '5S & G7', 'Posisi Kerja'] as $jenis)
                            <div class="form-check">
                                <input type="radio" name="jenis_temuan" value="{{ $jenis }}"
                                    class="form-check-input" onclick="showSubSection('{{ $jenisMap[$jenis] }}')"
                                    {{ old('jenis_temuan') == $jenis ? 'checked' : '' }} required>
                                <label class="form-check-label">{{ $jenis }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Sub section --}}
                <div id="sub-sections-wrapper" class="mb-3"></div>

                {{-- Situasi --}}
                <div class="mb-3">
                    <label class="form-label">Situasi / Kejadian</label>
                    <textarea name="situasi" id="situasi" rows="4" class="form-control"
                        placeholder="Deskripsikan situasi atau kejadian...">{{ old('situasi') }}</textarea>
                </div>

                {{-- Tindakan --}}
                <div class="mb-3">
                    <label class="form-label">Tindakan yang Sudah Dilakukan</label>
                    @php
                        $tindakanOptions = [
                            'Sudah diberitahukan kepada yang bersangkutan' =>
                                'Menghentikan UA dan langsung menegur pekerja',
                            'Sudah dilaporkan kepada atasan langsung' =>
                                'Langsung melakukan perbaikan terhadap Unsafe Condition (UC)',
                            'Sudah ditindaklanjuti dan diperbaiki' =>
                                'Melaporkan Unsafe Action (UA) dan Unsafe Condition (UC) ke atasan terkait',
                        ];
                    @endphp
                    @foreach ($tindakanOptions as $value => $label)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tindakan" value="{{ $value }}"
                                {{ old('tindakan') == $value ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $label }}</label>
                        </div>
                    @endforeach
                </div>

                {{-- Upload --}}
                <div class="mb-4">
                    <label class="form-label">Upload Foto</label>
                    <input type="file" name="bukti_gambar" id="foto" class="form-control"
                        accept=".jpeg,.jpg,.png">
                </div>

                <button type="submit" class="btn btn-primary">Kirim Laporan</button>

            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const subSectionsData = {
                    metode: ["Metode kerja tidak mencukupi", "Metode kerja tidak dimengerti",
                        "Metode kerja tidak dikerjakan"
                    ],
                    alat: ["Peralatan yang digunakan tidak sesuai",
                        "Tidak menggunakan peralatan sebagaimana mestinya",
                        "Peralatan yang digunakan tidak layak"
                    ],
                    apd: ["Pelindung Kepala", "Pelindung Mata/Wajah", "Pelindung Telinga",
                        "Pelindung Tangan atau Lengan", "Pelindung Badan", "Pelindung Kaki",
                        "Pelindung Jatuh atau Kejatuhan"
                    ],
                    "5s": ["5S dan G7"],
                    posisi: ["Tertabrak / Menabrak", "Terjepit / Terjebak", "Terjatuh / Tergelincir / Tersandung",
                        "Terpukul / Tertimpa / Kejatuhan", "Terpotong / Tertusuk",
                        "Kontak dengan temperatur Panas / Dingin", "Kontak dengan arus listrik",
                        "Kontak / Terhirup / Tertelan"
                    ]
                };

                window.showSubSection = function(section) {
                    const wrapper = document.getElementById('sub-sections-wrapper');
                    wrapper.innerHTML = '';
                    const groupName = 'sub_' + section;
                    const selected = '{{ old('sub_' . ($jenisMap[old('jenis_temuan')] ?? '')) }}';

                    const label = document.createElement('label');
                    label.className = 'form-label mt-3';
                    label.textContent = 'Detail ' + (section === '5s' ? '5S & G7' : section.charAt(0)
                        .toUpperCase() + section.slice(1));

                    const sectionDiv = document.createElement('div');
                    sectionDiv.className = 'sub-section mb-3';
                    sectionDiv.appendChild(label);

                    subSectionsData[section].forEach(option => {
                        const div = document.createElement('div');
                        div.className = 'form-check';

                        const input = document.createElement('input');
                        input.type = 'radio';
                        input.name = groupName;
                        input.value = option;
                        input.className = 'form-check-input';
                        if (option === selected) input.checked = true;

                        const optionLabel = document.createElement('label');
                        optionLabel.className = 'form-check-label';
                        optionLabel.textContent = option;

                        div.appendChild(input);
                        div.appendChild(optionLabel);
                        sectionDiv.appendChild(div);
                    });

                    wrapper.appendChild(sectionDiv);
                    sectionDiv.style.display = 'block';
                };

                const form = document.getElementById('observationForm');
                form.addEventListener('submit', function(e) {
                    const jenisTemuan = document.querySelector('input[name="jenis_temuan"]:checked');
                    const situasiInput = document.getElementById('situasi');
                    const situasi = situasiInput ? situasiInput.value.trim() : '';
                    const tindakan = document.querySelector('input[name="tindakan"]:checked');
                    const fotoInput = document.getElementById('foto');
                    const foto = fotoInput ? fotoInput.files.length : 0;

                    if (!jenisTemuan || !situasi || !tindakan) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Form Belum Lengkap',
                            text: 'Pastikan Jenis Temuan, Situasi, dan Tindakan sudah diisi.',
                            confirmButtonColor: '#d33'
                        });
                        return;
                    }

                    const map = {
                        'Metode': 'sub_metode',
                        'Alat/Fasilitas': 'sub_alat',
                        'APD': 'sub_apd',
                        '5S & G7': 'sub_5s',
                        'Posisi Kerja': 'sub_posisi'
                    };
                    const subName = map[jenisTemuan.value];
                    if (subName) {
                        const radios = document.querySelectorAll(
                            `#sub-sections-wrapper input[name="${subName}"]`);
                        const isAnyChecked = Array.from(radios).some(input => input.checked);

                        if (radios.length > 0 && !isAnyChecked) {
                            e.preventDefault();
                            Swal.fire({
                                icon: 'warning',
                                title: 'Detail Temuan Belum Diisi',
                                text: `Silakan pilih salah satu detail untuk ${jenisTemuan.value}.`,
                                confirmButtonColor: '#d33'
                            });
                            return;
                        }
                    }

                    if (foto === 0) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Upload Foto',
                            text: 'Tolong upload bukti foto sebagai dokumentasi.',
                            confirmButtonColor: '#d33'
                        });
                        return;
                    }
                });
            });
        </script>
    @endpush
@endsection
