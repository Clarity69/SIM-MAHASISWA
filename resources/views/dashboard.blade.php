@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('content')


{{-- HEADER DASHBOARD --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Dashboard</h2>
        <p class="text-muted mb-0">
            Selamat datang kembali, <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong>!
        </p>
    </div>
    <div>
        <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Mahasiswa
        </a>
    </div>
</div>

{{-- STATISTIK RINGKASAN --}}
<div class="row g-3 mb-4">
    {{-- TOTAL MAHASISWA --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted fw-semibold small">Total Mahasiswa</span>
                        <h2 class="fw-bold text-dark mt-1 mb-0">{{ $totalMahasiswa }}</h2>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- LAKI-LAKI --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted fw-semibold small">Laki-laki</span>
                        <h2 class="fw-bold text-info mt-1 mb-0">{{ $totalLakiLaki }}</h2>
                    </div>
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 text-info">
                        <i class="bi bi-person-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PEREMPUAN --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted fw-semibold small">Perempuan</span>
                        <h2 class="fw-bold text-danger mt-1 mb-0">{{ $totalPerempuan }}</h2>
                    </div>
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3 text-danger">
                        <i class="bi bi-person-heart fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TOTAL PRODI --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted fw-semibold small">Program Studi</span>
                        <h2 class="fw-bold text-success mt-1 mb-0">{{ $totalProdi }}</h2>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success">
                        <i class="bi bi-building fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- GRAFIK MAHASISWA PER PRODI --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Statistik Mahasiswa per Prodi</h5>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <div style="width: 100%; max-height: 280px;">
                    <canvas id="prodiChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- RINGKASAN REKAP PRODI --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Rekapitulasi Program Studi</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($mahasiswaPerProdi as $prodi)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                            <div>
                                <h6 class="fw-bold mb-0">{{ $prodi->nama_prodi }}</h6>
                                <small class="text-muted">{{ $prodi->kode_prodi }} - {{ $prodi->fakultas ?? '-' }}</small>
                            </div>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold">
                                {{ $prodi->mahasiswas_count }} Mahasiswa
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted py-4">
                            Belum ada data program studi.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- DATA MAHASISWA TERBARU --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Mahasiswa Terbaru</h5>
        <a href="{{ route('mahasiswa.index') }}" class="btn btn-sm btn-outline-primary">
            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">NIM</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>Jenis Kelamin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswaTerbaru as $mahasiswa)
                        <tr>
                            <td class="px-4 fw-semibold">{{ $mahasiswa->nim }}</td>
                            <td class="fw-bold">{{ $mahasiswa->nama }}</td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    {{ $mahasiswa->prodi->nama_prodi ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @if($mahasiswa->jenis_kelamin === 'Laki-laki')
                                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill">
                                        <i class="bi bi-person-fill me-1"></i>Laki-laki
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">
                                        <i class="bi bi-person-heart me-1"></i>Perempuan
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                Belum ada data mahasiswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- CDN Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('prodiChart').getContext('2d');
        
        const labels = {!! json_encode($mahasiswaPerProdi->pluck('kode_prodi')) !!};
        const data = {!! json_encode($mahasiswaPerProdi->pluck('mahasiswas_count')) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Mahasiswa',
                    data: data,
                    backgroundColor: 'rgba(13, 71, 161, 0.85)',
                    borderColor: '#0d47a1',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>
@endpush