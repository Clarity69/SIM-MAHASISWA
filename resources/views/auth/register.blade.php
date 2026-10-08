<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | SIM Mahasiswa</title>
    <link rel="icon" type="image/svg+xml" href="{{ ('favicon.svg') }}">

    {{-- Bootstrap 5 & Icons CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fb;
            font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 30px 15px; /* Memberikan ruang scroll di layar kecil */
        }
        .auth-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            padding: 40px;
            width: 100%;
            max-width: 420px;
        }
        .brand-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #0d47a1, #42a5f5);
            color: white;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 16px auto;
        }
        .form-control {
            padding: 12px 16px;
            border-radius: 10px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .form-control:focus {
            background-color: white;
            border-color: #0d47a1;
            box-shadow: 0 0 0 4px rgba(13, 71, 161, 0.1);
        }
        .btn-primary {
            background-color: #0d47a1;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .btn-primary:hover {
            background-color: #1565c0;
        }
    </style>
</head>
<body>

    <div class="auth-card">
        {{-- LOGO & JUDUL APLIKASI --}}
        <div class="text-center mb-4">
            <div class="brand-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h4 class="fw-bold mb-1 text-dark">Daftar Akun Baru</h4>
            <p class="text-muted small">Buat akun untuk mengakses SIM Mahasiswa</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- NAMA LENGKAP --}}
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold small text-dark">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus autocomplete="name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- EMAIL --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold small text-dark">Email</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="contoh@email.com" required autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- PASSWORD --}}
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold small text-dark">Password</label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- KONFIRMASI PASSWORD --}}
            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold small text-dark">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" required autocomplete="new-password">
            </div>

            {{-- SUBMIT BUTTON --}}
            <button type="submit" class="btn btn-primary w-100 shadow-sm mb-3">
                Daftar Sekarang
            </button>

            {{-- LINK KE LOGIN --}}
            <div class="text-center">
                <span class="small text-muted">Sudah punya akun? </span>
                <a href="{{ route('login') }}" class="small fw-semibold text-decoration-none" style="color: #0d47a1;">Masuk di sini</a>
            </div>
        </form>
    </div>

</body>
</html>