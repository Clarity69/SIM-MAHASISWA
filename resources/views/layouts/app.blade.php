<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | SIM Mahasiswa</title>

    {{-- Bootstrap 5 CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Bootstrap Icons CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            background: #f5f7fb;
            font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #1f2937;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #0d47a1 0%, #1565c0 50%, #0d47a1 100%);
            color: white;
            z-index: 1050;
            transition: all .3s ease;
            overflow-y: auto;
        }
        .sidebar-brand {
            height: 75px;
            display: flex;
            align-items: center;
            padding: 0 22px;
            font-size: 20px;
            font-weight: 700;
            color: white;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, .15);
        }
        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
        .sidebar-menu {
            padding: 20px 12px;
        }
        .menu-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, .55);
            padding: 10px 14px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            margin-bottom: 5px;
            color: rgba(255, 255, 255, .85);
            text-decoration: none;
            border-radius: 10px;
            transition: all .2s ease;
        }
        .sidebar-link i {
            font-size: 18px;
            width: 22px;
        }
        .sidebar-link:hover {
            background: rgba(255, 255, 255, .12);
            color: white;
            transform: translateX(3px);
        }
        .sidebar-link.active {
            background: white;
            color: #0d47a1;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .12);
        }

        /* MAIN WRAPPER & TOPBAR */
        .main-wrapper {
            margin-left: 250px;
            min-height: 100vh;
        }
        .topbar {
            height: 75px;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .page-title {
            font-weight: 700;
            font-size: 18px;
            margin: 0;
        }
        .page-subtitle {
            font-size: 12px;
            color: #9ca3af;
        }
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1565c0, #42a5f5);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        .user-name {
            font-size: 14px;
            font-weight: 600;
        }
        .user-role {
            font-size: 11px;
            color: #9ca3af;
        }

        /* CONTENT */
        .content {
            padding: 30px;
        }
        .card {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 3px 15px rgba(15, 23, 42, .06);
        }

        /* RESPONSIVE MOBILE */
        .sidebar-toggle {
            border: 0;
            background: transparent;
            font-size: 24px;
            color: #374151;
            display: none;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 1040;
        }
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .sidebar-overlay.show {
                display: block;
            }
            .main-wrapper {
                margin-left: 0;
            }
            .sidebar-toggle {
                display: block;
            }
            .content {
                padding: 20px;
            }
        }
        @media (max-width: 576px) {
            .topbar {
                padding: 0 15px;
            }
            .user-info {
                display: none;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- SIDEBAR --}}
    <aside id="sidebar" class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <span class="sidebar-brand-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </span>
            <span>SIM Mahasiswa</span>
        </a>

        <div class="sidebar-menu">
            <div class="menu-title">Menu Utama</div>

            {{-- DASHBOARD --}}
            <a href="{{ route('dashboard') }}" 
               class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            {{-- DATA MAHASISWA --}}
            <a href="{{ route('mahasiswa.index') }}" 
               class="sidebar-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Data Mahasiswa</span>
            </a>

            {{-- PROGRAM STUDI --}}
            <a href="{{ route('prodi.index') }}" 
               class="sidebar-link {{ request()->routeIs('prodi.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Program Studi</span>
            </a>

            <div class="menu-title mt-3">Pengaturan</div>

            {{-- PROFILE --}}
            <a href="{{ route('profile.edit') }}" 
               class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Profile</span>
            </a>

            {{-- LOGOUT --}}
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="sidebar-link border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- OVERLAY FOR MOBILE SIDEBAR --}}
    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    {{-- MAIN WRAPPER --}}
    <div class="main-wrapper">
        
        {{-- TOPBAR --}}
        <header class="topbar">
            <div class="topbar-left">
                <button id="sidebarToggle" class="sidebar-toggle" type="button">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <div class="page-title">@yield('page-title', 'Dashboard')</div>
                    <div class="page-subtitle">Sistem Informasi Data Mahasiswa</div>
                </div>
            </div>

            <div class="user-profile">
                <div class="user-info text-end">
                    <div class="user-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
                    <div class="user-role">Administrator</div>
                </div>
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT AREA --}}
        <main class="content">
            
            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- ALERT ERROR --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- VALIDATION ERRORS --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-exclamation-triangle me-2"></i>Terdapat kesalahan input:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- Bootstrap 5 JS Bundle CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // JS Toggle Sidebar Mobile
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('sidebarToggle');
        const overlay = document.getElementById('sidebarOverlay');

        toggle?.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });

        overlay?.addEventListener('click', function () {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    </script>

    @stack('scripts')
</body>
</html>