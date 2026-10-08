<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password | SIM Mahasiswa</title>
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
                <i class="bi bi-key-fill"></i>
            </div>
            <h4 class="fw-bold mb-1 text-dark">Lupa Password?</h4>
            <p class="text-muted small mb-0">
                Masukkan email akun Anda. Kami akan mengirimkan tautan untuk mengatur ulang password.
            </p>
        </div>

        {{-- STATUS SESSION (muncul setelah tautan reset terkirim) --}}
        @if (session('status'))
            <div class="alert alert-success small p-3 text-center border-0 rounded-3">
                <i class="bi bi-check-circle-fill me-1"></i> {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            {{-- EMAIL --}}
            <div class="mb-4">
                <label for="email" class="form-label fw-semibold small text-dark">Email</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="admin@example.com" required autofocus autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- SUBMIT BUTTON --}}
            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                <i class="bi bi-envelope-fill me-1"></i> Kirim Tautan Reset
            </button>
        </form>

        {{-- KEMBALI KE LOGIN --}}
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="back-link small">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke halaman login
            </a>
        </div>
    </div>

</body>
</html>