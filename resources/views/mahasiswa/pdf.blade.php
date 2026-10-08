@php
    /* =========================================================
       IDENTITAS INSTANSI UNTUK KOP — SILAKAN SESUAIKAN
    ========================================================== */
    $kop = [
        'yayasan'   => 'YAYASAN PENDIDIKAN NAMA YAYASAN',
        'instansi'  => 'UNIVERSITAS NAMA KAMPUS',
        'fakultas'  => 'FAKULTAS NAMA FAKULTAS',
        'alamat'    => 'Jalan Letjen S Parman No. 65 Bontang Barat, Kota Bontang, Kalimantan Timur, Kode Pos 75313',
        'kontak'    => 'Telp. (0548) 28782 · Email: admin@stitek.ac.id · Website: https://stitek.ac.id/',
        'kota'      => 'Bontang',
        'jabatan'   => 'Kepala Program Studi',
        'pejabat'   => 'Rianindya Chandra Hardika, S.T., M.Eng',
        'nip'       => '000000000000000000',
    ];

    // Logo kop: ganti dengan logo kampus (PNG/JPG) di folder public, misalnya public/logo-kampus.png
    $logoPath = public_path('stitek.png');
    $logo = null;
    if (file_exists($logoPath)) {
        $logoMime = str_ends_with($logoPath, '.svg') ? 'image/svg+xml' : mime_content_type($logoPath);
        $logo = 'data:' . $logoMime . ';base64,' . base64_encode(file_get_contents($logoPath));
    }

    $tanggalCetak = now()->locale('id')->translatedFormat('d F Y');
    $totalLaki = $mahasiswas->where('jenis_kelamin', 'Laki-laki')->count();
    $totalPerempuan = $mahasiswas->where('jenis_kelamin', 'Perempuan')->count();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
    <style>
        @page { margin: 1.5cm 1.8cm 1.8cm 1.8cm; }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            color: #000;
        }

        /* ===== KOP ===== */
        /* Kop = 3 kolom dengan lebar tetap: logo | teks | kolom kosong selebar logo,
           sehingga teks berada tepat di tengah halaman */
        .kop { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .kop td { vertical-align: middle; padding: 0; }
        .kop .logo { width: 15%; text-align: center; }
        .kop .logo img { width: 72px; height: 72px; }
        .kop .teks { width: 70%; text-align: center; }
        .kop .penyeimbang { width: 15%; }
        .kop .yayasan { font-size: 12pt; font-weight: bold; letter-spacing: .5px; }
        .kop .instansi { font-size: 18pt; font-weight: bold; letter-spacing: 1px; margin: 2px 0; }
        .kop .fakultas { font-size: 13pt; font-weight: bold; }
        .kop .alamat { font-size: 9.5pt; margin-top: 4px; }

        .garis-kop {
            border: 0;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin: 8px 0 18px 0;
        }

        /* ===== JUDUL ===== */
        .judul { text-align: center; margin-bottom: 14px; }
        .judul h1 { font-size: 14pt; margin: 0; text-decoration: underline; letter-spacing: .5px; }
        .judul p { margin: 3px 0 0 0; font-size: 11pt; }

        .info { width: 100%; margin-bottom: 10px; font-size: 10.5pt; border-collapse: collapse; }
        .info td { padding: 1px 0; }
        .info .label { width: 120px; }
        .info .titik { width: 12px; }

        /* ===== TABEL DATA ===== */
        .data { width: 100%; border-collapse: collapse; font-size: 10pt; }
        .data th, .data td { border: 1px solid #000; padding: 5px 6px; }
        .data th { background: #e6e6e6; text-align: center; font-weight: bold; }
        .data td.tengah { text-align: center; }
        .data tr { page-break-inside: avoid; }
        .data thead { display: table-header-group; } /* header tabel diulang di tiap halaman */

        .kosong { text-align: center; font-style: italic; padding: 14px; }

        /* ===== RINGKASAN & TANDA TANGAN ===== */
        .ringkasan { margin-top: 10px; font-size: 10.5pt; }
        .ttd { width: 100%; margin-top: 30px; border-collapse: collapse; page-break-inside: avoid; }
        .ttd td { vertical-align: top; font-size: 11pt; }
        .ttd .kanan { width: 280px; text-align: center; }
        .ttd .ruang { height: 70px; }
        .ttd .nama { font-weight: bold; text-decoration: underline; }

        /* ===== FOOTER NOMOR HALAMAN ===== */
        footer {
            position: fixed;
            bottom: -1.1cm;
            left: 0; right: 0;
            font-size: 8.5pt;
            color: #444;
            border-top: 1px solid #999;
            padding-top: 4px;
        }
        /* Pakai tabel, bukan float: float di elemen fixed membuat isi halaman bergeser di dompdf */
        footer table { width: 100%; border-collapse: collapse; }
        footer td { padding: 0; }
        footer .kanan { text-align: right; }
        footer .halaman:after { content: "Halaman " counter(page); }
    </style>
</head>
<body>

    <footer>
        <table>
            <tr>
                <td>Dicetak dari SIM Mahasiswa pada {{ now()->locale('id')->translatedFormat('d F Y, H:i') }}</td>
                <td class="kanan"><span class="halaman"></span></td>
            </tr>
        </table>
    </footer>

    {{-- ================= KOP ================= --}}
    <table class="kop">
        <tr>
            <td class="logo">
                @if ($logo)
                    <img src="{{ $logo }}" alt="Logo">
                @endif
            </td>
            <td class="teks">
                <div class="yayasan">{{ $kop['yayasan'] }}</div>
                <div class="instansi">{{ $kop['instansi'] }}</div>
                <div class="fakultas">{{ $kop['fakultas'] }}</div>
                <div class="alamat">{{ $kop['alamat'] }}<br>{{ $kop['kontak'] }}</div>
            </td>
            <td class="penyeimbang"></td>
        </tr>
    </table>
    <hr class="garis-kop">

    {{-- ================= JUDUL ================= --}}
    <div class="judul">
        <h1>DAFTAR DATA MAHASISWA</h1>
        <p>Tahun Akademik {{ now()->month >= 8 ? now()->year . '/' . (now()->year + 1) : (now()->year - 1) . '/' . now()->year }}</p>
    </div>

    <table class="info">
        <tr>
            <td class="label">Program Studi</td><td class="titik">:</td>
            <td>{{ $namaProdi }}</td>
        </tr>
        @if (!empty($search))
            <tr>
                <td class="label">Kata Kunci</td><td class="titik">:</td>
                <td>"{{ $search }}"</td>
            </tr>
        @endif
        <tr>
            <td class="label">Jumlah Data</td><td class="titik">:</td>
            <td>{{ $mahasiswas->count() }} mahasiswa</td>
        </tr>
    </table>

    {{-- ================= TABEL DATA ================= --}}
    <table class="data">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 12%;">NIM</th>
                <th style="width: 22%;">Nama Mahasiswa</th>
                <th style="width: 6%;">L/P</th>
                <th style="width: 11%;">Tanggal Lahir</th>
                <th style="width: 18%;">Program Studi</th>
                <th style="width: 12%;">Telepon</th>
                <th style="width: 15%;">Email</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mahasiswas as $mhs)
                <tr>
                    <td class="tengah">{{ $loop->iteration }}</td>
                    <td class="tengah">{{ $mhs->nim }}</td>
                    <td>{{ $mhs->nama }}</td>
                    <td class="tengah">{{ $mhs->jenis_kelamin === 'Laki-laki' ? 'L' : 'P' }}</td>
                    <td class="tengah">
                        {{ $mhs->tanggal_lahir ? \Carbon\Carbon::parse($mhs->tanggal_lahir)->locale('id')->translatedFormat('d M Y') : '-' }}
                    </td>
                    <td>{{ $mhs->prodi->nama_prodi ?? '-' }}</td>
                    <td>{{ $mhs->telepon ?: '-' }}</td>
                    <td>{{ $mhs->email ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="kosong">Tidak ada data mahasiswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ringkasan">
        Keterangan: L = Laki-laki ({{ $totalLaki }} orang), P = Perempuan ({{ $totalPerempuan }} orang).
    </div>

    {{-- ================= TANDA TANGAN ================= --}}
    <table class="ttd">
        <tr>
            <td></td>
            <td class="kanan">
                {{ $kop['kota'] }}, {{ $tanggalCetak }}<br>
                {{ $kop['jabatan'] }},
                <div class="ruang"></div>
                <span class="nama">{{ $kop['pejabat'] }}</span><br>
                NIP. {{ $kop['nip'] }}
            </td>
        </tr>
    </table>

</body>
</html>