@extends('layouts.app')

@section('title', 'Detail Mahasiswa')
@section('page-title', 'Detail Mahasiswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Detail Mahasiswa</h2>
        <p class="text-muted mb-0">Informasi lengkap profil mahasiswa.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('mahasiswa.edit', $mahasiswa) }}" class="btn btn-warning text-dark">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    {{-- CARD PROFIL --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body p-4">
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 90px; height: 90px;">
                    <i class="bi bi-person-fill fs-1"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $mahasiswa->nama }}</h4>
                <span class="badge bg-primary px-3 py-2 rounded-pill mb-3">{{ $mahasiswa->nim }}</span>
                <hr>
                <div class="text-start">
                    <small class="text-muted d-block mb-1">Program Studi</small>
                    <strong class="text-dark">{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- INFORMASI LENGKAP --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Informasi Mahasiswa</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block">NIM</small>
                        <span class="fw-semibold text-dark">{{ $mahasiswa->nim }}</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Nama Lengkap</small>
                        <span class="fw-semibold text-dark">{{ $mahasiswa->nama }}</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Jenis Kelamin</small>
                        <span class="fw-semibold text-dark">{{ $mahasiswa->jenis_kelamin }}</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Tanggal Lahir</small>
                        <span class="fw-semibold text-dark">
                            {{ $mahasiswa->tanggal_lahir ? $mahasiswa->tanggal_lahir->format('d-m-Y') : '-' }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Email</small>
                        <span class="fw-semibold text-dark">{{ $mahasiswa->email ?? '-' }}</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Telepon</small>
                        <span class="fw-semibold text-dark">{{ $mahasiswa->telepon ?? '-' }}</span>
                    </div>
                    <div class="col-12">
                        <small class="text-muted d-block">Alamat</small>
                        <span class="fw-semibold text-dark">{{ $mahasiswa->alamat ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection