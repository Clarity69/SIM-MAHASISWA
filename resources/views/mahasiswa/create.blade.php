@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')
@section('page-title', 'Tambah Mahasiswa')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Tambah Mahasiswa</h2>
    <p class="text-muted mb-0">Masukkan informasi lengkap mahasiswa baru.</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('mahasiswa.store') }}" method="POST">
            @csrf
            
            <div class="row g-3">
                {{-- NIM --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">NIM <span class="text-danger">*</span></label>
                    <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}" placeholder="Contoh: 22001001" required>
                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- NAMA LENGKAP --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PROGRAM STUDI --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Program Studi <span class="text-danger">*</span></label>
                    <select name="prodi_id" class="form-select @error('prodi_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach($prodis as $prodi)
                            <option value="{{ $prodi->id }}" @selected(old('prodi_id') == $prodi->id)>
                                {{ $prodi->nama_prodi }}
                            </option>
                        @endforeach
                    </select>
                    @error('prodi_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- JENIS KELAMIN --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" @selected(old('jenis_kelamin') === 'Laki-laki')>Laki-laki</option>
                        <option value="Perempuan" @selected(old('jenis_kelamin') === 'Perempuan')>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TANGGAL LAHIR --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TELEPON --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nomor Telepon</label>
                    <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon') }}" placeholder="08xxxxxxxxxx">
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="mahasiswa@example.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ALAMAT --}}
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Alamat</label>
                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex gap-2">
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection