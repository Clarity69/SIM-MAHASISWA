<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | SIM Mahasiswa</title>
    <link rel="icon" type="image/svg+xml" href="{{ ('favicon.svg') }}">

    {{-- Bootstrap 5 & Icons CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fb; /* Serasi dengan background dashboard */
            font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 16px;
        }
        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            padding: 40px;
            width: 100%;
            max-width: 400px;
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
        .form-control[readonly] {
            background-color: #eef2f7;
            color: #64748b;
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
        /* Tombol lihat/sembunyikan password */
        .password-wrapper { position: relative; }
        .password-wrapper .form-control { padding-right: 46px; }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #94a3b8;
            font-size: 18px;
            cursor: pointer;
            padding: 4px;
        }
        .toggle-password:hover { color: #0d47a1; }
        .password-wrapper .form-control.is-invalid ~ .toggle-password { right: 36px; }
        .back-link {
            color: #0d47a1;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-card">
        {{-- IKON & JUDUL --}}
        <div class="text-center mb-4">
            <div class="brand-icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h4 class="fw-bold mb-1 text-dark">Buat Password Baru</h4>
            <p class="text-muted small mb-0">
                Masukkan password baru untuk akun Anda. Gunakan minimal 8 karakter.
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            {{-- TOKEN RESET (WAJIB, JANGAN DIHAPUS) --}}
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{-- EMAIL (sudah terisi dari tautan email) --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold small text-dark">Email</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $request->email) }}" required readonly autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- PASSWORD BARU --}}
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold small text-dark">Password Baru</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" minlength="8" required autofocus autocomplete="new-password">
                    <button type="button" class="toggle-password" data-target="password" aria-label="Tampilkan password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- KONFIRMASI PASSWORD --}}
            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold small text-dark">Konfirmasi Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="••••••••" minlength="8" required autocomplete="new-password">
                    <button type="button" class="toggle-password" data-target="password_confirmation" aria-label="Tampilkan password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- SUBMIT BUTTON --}}
            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                <i class="bi bi-check2-circle me-1"></i> Simpan Password Baru
            </button>
        </form>

        {{-- KEMBALI KE LOGIN --}}
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="back-link small">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke halaman login
            </a>
        </div>
    </div>

    <script>
        // Tampilkan / sembunyikan password
        document.querySelectorAll('.toggle-password').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const input = document.getElementById(this.dataset.target);
                const icon = this.querySelector('i');
                const show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
                this.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
            });
        });
    </script>

</body>
</html>