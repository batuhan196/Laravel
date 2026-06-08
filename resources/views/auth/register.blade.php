<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Okul Envanter Sistemi - Kayıt Ol</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif
        }

        body {
            background: #0a0a0f;
            color: #e4e4e7;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden
        }

        body::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.08) 0%, transparent 70%);
            top: -200px;
            right: -200px;
            pointer-events: none
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(239, 68, 68, 0.05) 0%, transparent 70%);
            bottom: -100px;
            left: -100px;
            pointer-events: none
        }

        .register-container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
            position: relative;
            z-index: 1
        }

        .register-logo {
            text-align: center;
            margin-bottom: 2rem
        }

        .register-logo .icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 30px rgba(245, 158, 11, 0.3);
            animation: float 3s ease-in-out infinite
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-10px)
            }
        }

        .register-logo h1 {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent
        }

        .register-logo p {
            font-size: .85rem;
            color: #71717a;
            margin-top: .25rem
        }

        .register-card {
            background: #1a1a2e;
            border: 1px solid #2a2a4a;
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5)
        }

        .form-group {
            margin-bottom: 1.25rem
        }

        .form-label {
            display: block;
            font-size: .8rem;
            font-weight: 600;
            color: #a1a1aa;
            margin-bottom: .4rem
        }

        .form-input {
            width: 100%;
            padding: .75rem 1rem;
            background: #0a0a0f;
            border: 1px solid #2a2a4a;
            border-radius: 12px;
            color: #e4e4e7;
            font-size: .9rem;
            outline: none;
            transition: .2s
        }

        .form-input:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1)
        }

        .form-error {
            font-size: .75rem;
            color: #ef4444;
            margin-top: .3rem
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem
        }

        .btn-register {
            width: 100%;
            padding: .8rem;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #000;
            border: none;
            border-radius: 12px;
            font-size: .9rem;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3)
        }

        .login-link {
            text-align: center;
            margin-top: 1.25rem;
            font-size: .8rem;
            color: #71717a
        }

        .login-link a {
            color: #f59e0b;
            text-decoration: none;
            font-weight: 600
        }

        .login-link a:hover {
            text-decoration: underline
        }

        .turnstile-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 1.25rem
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-logo">
            <div class="icon">🏫</div>
            <h1>Okul Envanter Sistemi</h1>
            <p>Yeni Hesap Oluştur</p>
        </div>
        <div class="register-card">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-user" style="margin-right:4px"></i> Ad Soyad</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name') }}"
                        placeholder="Adınız Soyadınız" required autofocus>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-envelope" style="margin-right:4px"></i> E-posta
                        Adresi</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email') }}"
                        placeholder="ornek@okul.com" required>
                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-lock" style="margin-right:4px"></i> Şifre</label>
                        <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                        @error('password')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-lock" style="margin-right:4px"></i> Şifre
                            Tekrar</label>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="••••••••"
                            required>
                    </div>
                </div>
                <div class="turnstile-wrapper">
                    <div class="cf-turnstile" data-sitekey="{{ config('turnstile.site_key') }}" data-theme="dark"></div>
                </div>
                @error('cf-turnstile-response')<div class="form-error" style="text-align:center;margin-bottom:1rem">
                {{ $message }}</div>@enderror
                <button type="submit" class="btn-register"><i class="fas fa-user-plus"></i> Kayıt Ol</button>
            </form>
            <div class="login-link">
                Zaten hesabınız var mı? <a href="{{ route('login') }}">Giriş Yap</a>
            </div>
        </div>
    </div>
</body>

</html>