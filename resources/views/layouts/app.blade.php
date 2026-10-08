<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | SIM Mahasiswa</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- SCRIPT PENCEGAH KEDIP (FOUC) - Dieksekusi sebelum body dimuat --}}
    <script>
        const theme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', theme);

        if (localStorage.getItem('sidebar_hidden') === 'true') {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    </script>

    {{-- Bootstrap 5 CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        /* WARNA DEFAULT (LIGHT) */
        body {
            margin: 0;
            background: #f5f7fb;
            font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #1f2937;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* OVERRIDE WARNA UNTUK DARK MODE */
        [data-bs-theme="dark"] body { background: #0f172a; color: #f8fafc; }
        [data-bs-theme="dark"] .card, [data-bs-theme="dark"] .topbar, [data-bs-theme="dark"] .dropdown-menu {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc;
        }
        [data-bs-theme="dark"] .text-dark { color: #f8fafc !important; }
        [data-bs-theme="dark"] .bg-white { background-color: #1e293b !important; }
        [data-bs-theme="dark"] .bg-light { background-color: #0f172a !important; }
        [data-bs-theme="dark"] .text-muted { color: #94a3b8 !important; }
        [data-bs-theme="dark"] .table { --bs-table-bg: transparent; color: #f8fafc; }
        [data-bs-theme="dark"] .table-light th { background-color: #334155; color: #f8fafc; border-color: #475569; }

        /* ===================== SIDEBAR ===================== */
        /* Warna sidebar disimpan sebagai variabel agar mudah diganti per tema */
        :root {
            --sidebar-bg: linear-gradient(180deg, #0d47a1 0%, #1565c0 50%, #0d47a1 100%);
            --sidebar-border: rgba(255, 255, 255, .15);
            --sidebar-text: rgba(255, 255, 255, .85);
            --sidebar-muted: rgba(255, 255, 255, .55);
            --sidebar-hover-bg: rgba(255, 255, 255, .12);
            --sidebar-icon-bg: rgba(255, 255, 255, .15);
            --sidebar-active-bg: #ffffff;
            --sidebar-active-text: #0d47a1;
        }
        [data-bs-theme="dark"] {
            --sidebar-bg: linear-gradient(180deg, #0b1220 0%, #111827 50%, #0b1220 100%);
            --sidebar-border: #1e293b;
            --sidebar-text: #cbd5e1;
            --sidebar-muted: #64748b;
            --sidebar-hover-bg: rgba(148, 163, 184, .12);
            --sidebar-icon-bg: rgba(59, 130, 246, .18);
            --sidebar-active-bg: rgba(59, 130, 246, .2);
            --sidebar-active-text: #93c5fd;
        }

        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 250px; height: 100vh;
            background: var(--sidebar-bg);
            color: white; z-index: 1050;
            border-right: 1px solid var(--sidebar-border);
            transition: all .3s ease;
            overflow-y: auto;
        }
        .main-wrapper {
            margin-left: 250px;
            min-height: 100vh;
            transition: all .3s ease;
        }

        /* LOGIKA SIDEBAR COLLAPSED (DESKTOP) */
        @media (min-width: 992px) {
            html.sidebar-collapsed .sidebar { transform: translateX(-100%); }
            html.sidebar-collapsed .main-wrapper { margin-left: 0; }
        }

        /* LOGIKA SIDEBAR MOBILE */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .sidebar-overlay.show { display: block; }
        }

        /* BRAND & MENU SIDEBAR */
        .sidebar-brand {
            height: 75px; display: flex; align-items: center; padding: 0 22px;
            font-size: 20px; font-weight: 700; color: white; text-decoration: none;
            border-bottom: 1px solid var(--sidebar-border);
        }
        .sidebar-brand:hover { color: white; }
        .sidebar-brand-icon {
            width: 40px; height: 40px; border-radius: 10px; background: var(--sidebar-icon-bg);
            display: flex; align-items: center; justify-content: center; margin-right: 10px;
        }
        .sidebar-menu { padding: 20px 12px; }
        .menu-title {
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1px; color: var(--sidebar-muted); padding: 10px 14px;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 12px; padding: 12px 14px; margin-bottom: 5px;
            color: var(--sidebar-text); text-decoration: none; border-radius: 10px; transition: all .2s ease;
        }
        .sidebar-link i { font-size: 18px; width: 22px; }
        .sidebar-link:hover { background: var(--sidebar-hover-bg); color: white; transform: translateX(3px); }
        .sidebar-link.active {
            background: var(--sidebar-active-bg); color: var(--sidebar-active-text);
            font-weight: 600; box-shadow: 0 4px 12px rgba(0, 0, 0, .12);
        }

        /* TOMBOL TOGGLE TEMA DI SIDEBAR */
        .theme-toggle {
            width: 100%; border: 0; background: transparent; text-align: left; cursor: pointer;
        }
        .theme-toggle .form-switch { margin-left: auto; padding-left: 0; margin-bottom: 0; }
        .theme-toggle .form-check-input { margin-left: 0; cursor: pointer; pointer-events: none; }

        /* TOMBOL LOGOUT DI SIDEBAR */
        .sidebar-logout {
            width: 100%; border: 0; background: transparent; text-align: left; cursor: pointer;
        }
        .sidebar-logout:hover { background: rgba(220, 53, 69, .25); color: #fff; }
        [data-bs-theme="dark"] .sidebar-logout:hover { background: rgba(220, 53, 69, .18); color: #fca5a5; }

        /* TOPBAR & KOMPONEN LAIN */
        .topbar {
            height: 75px; background: white; border-bottom: 1px solid #e5e7eb;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 30px; position: sticky; top: 0; z-index: 1000;
        }
        .topbar-left { display: flex; align-items: center; gap: 15px; }
        .sidebar-toggle { border: 0; background: transparent; font-size: 24px; color: inherit; cursor: pointer; }
        .page-title { font-weight: 700; font-size: 18px; margin: 0; }
        .page-subtitle { font-size: 12px; color: #9ca3af; }

        .user-avatar {
            width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #1565c0, #42a5f5);
            color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;
        }

        .content { padding: 30px; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, .45); z-index: 1040; }

        /* EFEK DROPDOWN */
        .hover-scale { transition: transform 0.2s ease; }
        .user-profile:hover .hover-scale { transform: scale(1.05); }
        .dropdown-item:hover { background-color: rgba(13, 71, 161, 0.05); color: #0d47a1; }
        .dropdown-item.text-danger:hover { background-color: #fef2f2 !important; color: #dc3545 !important; }
        [data-bs-theme="dark"] .dropdown-item:hover { background-color: rgba(59, 130, 246, .12); color: #93c5fd; }
        [data-bs-theme="dark"] .dropdown-item.text-danger:hover { background-color: rgba(220, 53, 69, .15) !important; }

        /* MODAL KONFIRMASI HAPUS */
        .modal-hapus-icon {
            width: 64px; height: 64px; border-radius: 50%;
            background: rgba(220, 53, 69, .12); color: #dc3545;
            display: flex; align-items: center; justify-content: center; font-size: 28px;
        }
        [data-bs-theme="dark"] .modal-content { background-color: #1e293b; color: #f8fafc; }
        [data-bs-theme="dark"] .modal-content .btn-light { background-color: #334155; border-color: #334155; color: #f8fafc; }
    </style>

    @stack('styles')
</head>
<body>

    {{-- SIDEBAR --}}
    <aside id="sidebar" class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <span class="sidebar-brand-icon"><i class="bi bi-mortarboard-fill"></i></span>
            <span>SIM Mahasiswa</span>
        </a>
        <div class="sidebar-menu">
            <div class="menu-title">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('mahasiswa.index') }}" class="sidebar-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i><span>Data Mahasiswa</span>
            </a>
            <a href="{{ route('prodi.index') }}" class="sidebar-link {{ request()->routeIs('prodi.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i><span>Program Studi</span>
            </a>
            <div class="menu-title mt-3">Pengaturan</div>
            <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i><span>Profile</span>
            </a>

            {{-- TOGGLE DARK / LIGHT MODE --}}
            <button id="themeToggle" type="button" class="sidebar-link theme-toggle" title="Ganti Tema">
                <i id="themeIcon" class="bi bi-moon-stars-fill"></i>
                <span id="themeLabel">Mode Gelap</span>
                <div class="form-check form-switch">
                    <input id="themeSwitch" class="form-check-input" type="checkbox" role="switch" tabindex="-1">
                </div>
            </button>

            {{-- LOGOUT --}}
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="sidebar-link sidebar-logout">
                    <i class="bi bi-box-arrow-right"></i><span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    {{-- MAIN WRAPPER --}}
    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                {{-- TOMBOL TOGGLE SIDEBAR SEKARANG MUNCUL DI DESKTOP JUGA --}}
                <button id="sidebarToggle" class="sidebar-toggle" type="button" title="Toggle Sidebar">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <div class="page-title">@yield('page-title', 'Dashboard')</div>
                    <div class="page-subtitle">Sistem Informasi Data Mahasiswa</div>
                </div>
            </div>

            {{-- DROPDOWN PROFILE (Diperbarui) --}}
            <div class="dropdown">
                <div class="user-profile d-flex align-items-center gap-2" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                    <div class="user-info text-end d-none d-sm-block">
                        <div class="user-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
                        <div class="user-role">Administrator</div>
                    </div>
                    <div class="user-avatar transition-transform hover-scale">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <i class="bi bi-chevron-down text-muted ms-1" style="font-size: 12px;"></i>
                </div>

                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3" style="border-radius: 12px; min-width: 240px;">
                    <li>
                        <div class="px-4 py-3 bg-light rounded-top text-center border-bottom">
                            <span class="d-block fw-bold">{{ auth()->user()->name ?? 'Administrator' }}</span>
                            <span class="d-block small text-muted">{{ auth()->user()->email ?? 'admin@example.com' }}</span>
                        </div>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-3 py-2 px-4 mt-2" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-circle fs-5 text-primary"></i> <span>Profile Saya</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider mx-3 my-2"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-3 py-2 px-4 text-danger mb-1">
                                <i class="bi bi-box-arrow-right fs-5"></i> <span class="fw-semibold">Keluar</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <main class="content">
            @yield('content')
        </main>
    </div>

    {{-- MODAL KONFIRMASI HAPUS (dipakai semua form dengan class "form-hapus") --}}
    <div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 16px;">
                <div class="modal-body text-center p-4">
                    <div class="modal-hapus-icon mx-auto mb-3">
                        <i class="bi bi-trash3-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-2" id="modalHapusLabel">Hapus <span id="modalHapusJenis">data</span>?</h5>
                    <p class="text-muted mb-1">Anda akan menghapus:</p>
                    <p class="fw-semibold mb-3" id="modalHapusNama">-</p>
                    <p class="small text-danger mb-0">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>Data yang dihapus tidak dapat dikembalikan.
                    </p>
                </div>
                <div class="modal-footer border-0 justify-content-center gap-2 pt-0 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger px-4" id="modalHapusKonfirmasi">
                        <i class="bi bi-trash me-1"></i> Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // LOGIKA TOGGLE SIDEBAR DINAMIS
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const htmlElement = document.documentElement;

        // Fungsi global: dipakai tombol topbar DAN switch di halaman Profile
        window.setSidebarHidden = function (hidden) {
            htmlElement.classList.toggle('sidebar-collapsed', hidden);
            localStorage.setItem('sidebar_hidden', hidden);
            document.dispatchEvent(new CustomEvent('sidebarchange', { detail: hidden }));
        };

        toggleBtn?.addEventListener('click', () => {
            if (window.innerWidth >= 992) {
                // Di Desktop: Tambah/hapus class pada HTML dan simpan ke LocalStorage
                setSidebarHidden(!htmlElement.classList.contains('sidebar-collapsed'));
            } else {
                // Di Mobile: Pakai class 'show' biasa tanpa disimpan ke LocalStorage
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }
        });

        overlay?.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });

        // LOGIKA TOGGLE DARK / LIGHT MODE
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const themeLabel = document.getElementById('themeLabel');
        const themeSwitch = document.getElementById('themeSwitch');

        function applyThemeUI(theme) {
            const isDark = theme === 'dark';
            themeSwitch.checked = isDark;
            themeIcon.className = isDark ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
            themeLabel.textContent = isDark ? 'Mode Terang' : 'Mode Gelap';
        }

        // Sinkronkan tampilan tombol dengan tema yang sudah dipasang di <head>
        applyThemeUI(htmlElement.getAttribute('data-bs-theme'));

        // Fungsi global: dipakai tombol sidebar DAN switch di halaman Profile
        window.setTheme = function (theme) {
            htmlElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);
            applyThemeUI(theme);
            document.dispatchEvent(new CustomEvent('themechange', { detail: theme }));
        };

        themeToggle?.addEventListener('click', () => {
            const current = htmlElement.getAttribute('data-bs-theme');
            setTheme(current === 'dark' ? 'light' : 'dark');
        });

        // LOGIKA MODAL KONFIRMASI HAPUS
        const modalHapusEl = document.getElementById('modalHapus');
        const modalHapus = new bootstrap.Modal(modalHapusEl);
        const btnKonfirmasiHapus = document.getElementById('modalHapusKonfirmasi');
        let formAkanDihapus = null;

        // Tangkap submit dari form ber-class "form-hapus", tampilkan modal dulu
        document.addEventListener('submit', (e) => {
            const form = e.target.closest('.form-hapus');
            if (!form || form.dataset.terkonfirmasi === 'true') return;

            e.preventDefault();
            formAkanDihapus = form;
            document.getElementById('modalHapusJenis').textContent = form.dataset.jenis || 'data';
            document.getElementById('modalHapusNama').textContent = form.dataset.nama || 'data ini';
            btnKonfirmasiHapus.disabled = false;
            modalHapus.show();
        });

        // Klik "Ya, Hapus" -> kirim form yang tadi ditahan
        btnKonfirmasiHapus.addEventListener('click', () => {
            if (!formAkanDihapus) return;
            btnKonfirmasiHapus.disabled = true; // cegah klik dua kali
            btnKonfirmasiHapus.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menghapus...';
            formAkanDihapus.dataset.terkonfirmasi = 'true';
            formAkanDihapus.submit();
        });

        // Reset saat modal ditutup tanpa menghapus
        modalHapusEl.addEventListener('hidden.bs.modal', () => {
            formAkanDihapus = null;
            btnKonfirmasiHapus.innerHTML = '<i class="bi bi-trash me-1"></i> Ya, Hapus';
        });
    </script>
    @stack('scripts')
</body>
</html>