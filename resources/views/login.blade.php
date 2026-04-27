<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Dexornit</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f7faf7;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .login-wrap {
            width: 100%;
            max-width: 400px;
        }

        /* ── Brand ── */
        .brand {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-logo-wrap {
            width: 72px;
            height: 72px;
            background: #4a9058;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            box-shadow: 0 4px 14px rgba(74,144,88,0.25);
        }

        .brand-logo {
            height: 46px;
            width: 46px;
            object-fit: contain;
        }

        .brand h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: #2c3e2d;
            letter-spacing: -0.3px;
        }

        .brand p {
            font-size: 0.85rem;
            color: #6b7f6c;
            margin-top: 4px;
        }

        /* ── Card ── */
        .card {
            background: #fff;
            border: 1px solid #dde8de;
            border-radius: 16px;
            padding: 32px 28px;
            box-shadow: 0 4px 20px rgba(44,62,45,0.08);
        }

        /* ── Form ── */
        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #2c3e2d;
            margin-bottom: 6px;
        }

        label i {
            color: #9bcba3;
            font-size: 0.85rem;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i.input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #9bcba3;
            font-size: 0.85rem;
            pointer-events: none;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 14px 10px 38px;
            border: 1px solid #dde8de;
            border-radius: 9px;
            font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            color: #2c3e2d;
            background: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        input:focus {
            border-color: #4a9058;
            box-shadow: 0 0 0 3px rgba(74,144,88,0.12);
        }

        /* ── Alert ── */
        .alert-error {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fdf3f2;
            border: 1px solid #f5c6c2;
            border-radius: 9px;
            padding: 10px 14px;
            font-size: 0.82rem;
            color: #c0392b;
            margin-bottom: 18px;
        }

        /* ── Button ── */
        .btn-submit {
            width: 100%;
            padding: 11px;
            background: #4a9058;
            color: #fff;
            border: none;
            border-radius: 9px;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            letter-spacing: 0.2px;
            transition: background 0.2s, transform 0.1s;
            margin-top: 4px;
        }

        .btn-submit:hover  { background: #3a7347; }
        .btn-submit:active { transform: scale(0.99); }

        /* ── Hint ── */
        .hint {
            text-align: center;
            margin-top: 14px;
            font-size: 0.78rem;
            color: #9bcba3;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            .card { padding: 24px 18px; }
            .brand h1 { font-size: 1.2rem; }
            .brand-logo-wrap { width: 60px; height: 60px; border-radius: 14px; }
            .brand-logo { height: 38px; width: 38px; }
        }
    </style>
</head>
<body>
    <div class="login-wrap">

        {{-- Brand --}}
        <div class="brand">
            <div class="brand-logo-wrap">
                <img src="{{ asset('images/LogoD.png') }}" alt="Dexornit Logo" class="brand-logo">
            </div>
            <h1>Dexornit</h1>
            <p>Ruang kerja minimalis Anda</p>
        </div>

        {{-- Card --}}
        <div class="card">
            @if(session('error'))
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST">
                @csrf

                {{-- Username --}}
                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-user"></i> Username
                    </label>
                    <div class="input-wrap">
                        <i class="fas fa-user input-icon"></i>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Masukkan username..."
                            autocomplete="off"
                            required
                        >
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            autocomplete="off"
                        >
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>
        </div>

        <p class="hint">
            <i class="fas fa-info-circle"></i>
            Password bebas, yang penting username diisi.
        </p>
    </div>
</body>
</html>
