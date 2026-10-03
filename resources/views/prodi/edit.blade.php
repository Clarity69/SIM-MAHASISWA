@extends('layouts.app')

@section('title', 'Edit Program Studi')
@section('page-title', 'Edit Program Studi')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Edit Program Studi</h2>
    <p class="text-muted mb-0">Perbarui informasi program studi.</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('prodi.update', $prodi) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-3">
                {{-- KODE PRODI --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kode Program Studi <span class="text-danger">*</span></label>
                    <input type="text" name="kode_prodi" class="form-control @error('kode_prodi') is-invalid @enderror" value="{{ old('kode_prodi', $prodi->kode_prodi) }}" required>
                    @error('kode_prodi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- NAMA PRODI --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Program Studi <span class="text-danger">*</span></label>
                    <input type="text" name="nama_prodi" class="form-control @error('nama_prodi') is-invalid @enderror" value="{{ old('nama_prodi', $prodi->nama_prodi) }}" required>
                    @error('nama_prodi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- FAKULTAS --}}
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Fakultas</label>
                    <input type="text" name="fakultas" class="form-control @error('fakultas') is-invalid @enderror" value="{{ old('fakultas', $prodi->fakultas) }}">
                    @error('fakultas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex gap-2">
                <a href="{{ route('prodi.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection