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
        {{-- sticky hanya di desktop, z-index rendah agar tidak menutupi dropdown topbar --}}
        <div class="card border-0 shadow-sm text-center sticky-lg-top" style="top: 100px; z-index: 1;">
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
                        <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Alamat Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
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

        {{-- =====================================================
             FORM PREFERENSI TAMPILAN (UI/UX)
        ====================================================== --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom text-start d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-0">Tampilan</h5>
                    <small class="text-muted">Personalisasi pengalaman antarmuka Anda.</small>
                </div>
                <i class="bi bi-palette text-primary fs-3"></i>
            </div>
            <div class="card-body p-4">

                {{-- TOGGLE DARK MODE --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <label for="darkModeToggle" style="cursor: pointer;">
                        <h6 class="fw-bold mb-1"><i class="bi bi-moon-stars me-2"></i>Mode Gelap (Dark Mode)</h6>
                        <small class="text-muted">Ubah skema warna aplikasi menjadi gelap.</small>
                    </label>
                    <div class="form-check form-switch fs-4 mb-0">
                        <input class="form-check-input shadow-none" type="checkbox" role="switch" id="darkModeToggle" style="cursor: pointer;">
                    </div>
                </div>

                <hr class="text-muted opacity-25">

                {{-- TOGGLE SEMBUNYIKAN SIDEBAR (hanya berpengaruh di desktop) --}}
                <div class="d-none d-lg-flex justify-content-between align-items-center mt-4">
                    <label for="sidebarToggleSwitch" style="cursor: pointer;">
                        <h6 class="fw-bold mb-1"><i class="bi bi-layout-sidebar me-2"></i>Sembunyikan Sidebar</h6>
                        <small class="text-muted">Sidebar akan disembunyikan secara default saat aplikasi dibuka (Desktop).</small>
                    </label>
                    <div class="form-check form-switch fs-4 mb-0">
                        <input class="form-check-input shadow-none" type="checkbox" role="switch" id="sidebarToggleSwitch" style="cursor: pointer;">
                    </div>
                </div>

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
                        <label for="current_password" class="form-label fw-semibold">Password Saat Ini</label>
                        <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" autocomplete="current-password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-4">
                        {{-- PASSWORD BARU --}}
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">Password Baru</label>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="8" autocomplete="new-password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- KONFIRMASI PASSWORD --}}
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" minlength="8" autocomplete="new-password" required>
                        </div>
                    </div>

                    <div class="text-end">
                        {{-- btn-dark hampir tak terlihat di dark mode, jadi pakai btn-primary --}}
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-key me-1"></i> Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const htmlElement = document.documentElement;

        // --- 1. DARK MODE ---
        const darkModeToggle = document.getElementById('darkModeToggle');

        // State awal mengikuti tema yang sedang aktif
        darkModeToggle.checked = htmlElement.getAttribute('data-bs-theme') === 'dark';

        // Pakai fungsi global dari layout agar tombol di sidebar ikut berubah
        darkModeToggle.addEventListener('change', function () {
            window.setTheme(this.checked ? 'dark' : 'light');
        });

        // Kalau tema diganti dari sidebar, switch di sini ikut berubah
        document.addEventListener('themechange', function (e) {
            darkModeToggle.checked = e.detail === 'dark';
        });

        // --- 2. SIDEBAR ---
        const sidebarSwitch = document.getElementById('sidebarToggleSwitch');

        sidebarSwitch.checked = htmlElement.classList.contains('sidebar-collapsed');

        sidebarSwitch.addEventListener('change', function () {
            window.setSidebarHidden(this.checked);
        });

        // Kalau sidebar disembunyikan lewat tombol topbar, switch di sini ikut berubah
        document.addEventListener('sidebarchange', function (e) {
            sidebarSwitch.checked = e.detail;
        });
    });
</script>
@endpush