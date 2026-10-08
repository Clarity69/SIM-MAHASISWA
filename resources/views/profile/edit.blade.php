@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'Profile')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Profile Saya</h2>
    <p class="text-muted mb-0">Kelola informasi akun dan keamanan Anda.</p>
</div>

<div class="row g-4">
    {{-- =====================================================
         KOLOM KIRI: INFORMASI AKUN RINGKAS
    ====================================================== --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm text-center sticky-top" style="top: 100px;">
            <div class="card-body p-4">
                {{-- AVATAR --}}
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold" style="width: 100px; height: 100px; font-size: 40px;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                
                {{-- INFO USER --}}
                <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                
                <span class="badge bg-success bg-opacity-10 text-success px-4 py-2 rounded-pill fw-bold">
                    <i class="bi bi-shield-check me-1"></i> Administrator
                </span>
            </div>
        </div>
    </div>

    {{-- =====================================================
         KOLOM KANAN: FORM EDIT
    ====================================================== --}}
    <div class="col-lg-8">
        
        {{-- FORM INFORMASI PROFILE --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom text-start">
                <h5 class="fw-bold mb-0">Informasi Profile</h5>
                <small class="text-muted">Perbarui nama dan alamat email akun Anda.</small>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    {{-- NAMA --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Alamat Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- FORM UBAH PASSWORD --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom text-start">
                <h5 class="fw-bold mb-0">Ubah Password</h5>
                <small class="text-muted">Gunakan password yang kuat dan minimal 8 karakter.</small>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- PASSWORD LAMA --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-4">
                        {{-- PASSWORD BARU --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password Baru</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- KONFIRMASI PASSWORD --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-dark">
                            <i class="bi bi-key me-1"></i> Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection