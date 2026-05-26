<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Scholarchive</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/lg.png') }}" type="image/png">
    <style>
        :root {
            --bg-color: #0b0f19;
            --card-bg: rgba(22, 27, 43, 0.7);
            --card-border: rgba(148, 163, 184, 0.12);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --primary: #6366f1;
            --primary-hover: #818cf8;
            --input-bg: rgba(15, 23, 42, 0.5);
            --input-border: rgba(148, 163, 184, 0.2);
        }
        
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Top radial glow */
        .glow-effect {
            position: absolute;
            top: -250px;
            left: 50%;
            transform: translateX(-50%);
            width: 1000px;
            height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, rgba(139,92,246,0.15) 30%, rgba(11,15,25,0) 70%);
            z-index: 0;
            pointer-events: none;
            filter: blur(60px);
        }

        .auth-wrapper {
            width: 100%;
            max-width: 440px;
            padding: 2rem 1.5rem;
            position: relative;
            z-index: 1;
        }

        .auth-brand {
            text-align: center;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
        .auth-brand img { 
            height: 56px; 
            opacity: 0;
            transform: scale(0.7) translateY(-20px);
            animation: authLogoEnter 1s cubic-bezier(0.34, 1.56, 0.64, 1) forwards, authLogoFloat 4s ease-in-out infinite 1s;
        }

        .auth-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 1.25rem;
            padding: 2.5rem;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255,255,255,0.05);
            animation: scaleUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .auth-icon {
            width: 56px;
            height: 56px;
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            color: var(--primary);
        }
        .auth-title {
            font-size: 1.375rem;
            font-weight: 700;
            margin: 0 0 0.5rem;
            color: #fff;
            letter-spacing: -0.01em;
        }
        .auth-subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin: 0;
        }

        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 500;
            color: #cbd5e1;
            margin-bottom: 0.5rem;
        }
        .form-control {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 0.625rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: #fff;
            font-family: inherit;
            transition: all 0.2s;
            box-sizing: border-box;
        }
        .form-control::placeholder { color: #475569; }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
            background: rgba(15, 23, 42, 0.8);
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            border-radius: 0.625rem;
            border: none;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            margin-top: 0.5rem;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .auth-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--text-muted);
        }
        .auth-link {
            color: var(--primary-hover);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .auth-link:hover { color: #a5b4fc; }

        .checkbox-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.8125rem;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            color: var(--text-muted);
        }
        .custom-checkbox {
            appearance: none;
            width: 16px;
            height: 16px;
            border: 1px solid var(--input-border);
            border-radius: 0.25rem;
            background: var(--input-bg);
            cursor: pointer;
            position: relative;
        }
        .custom-checkbox:checked {
            background: var(--primary);
            border-color: var(--primary);
        }
        .custom-checkbox:checked::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 10px;
            font-weight: bold;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }

        .alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            margin-bottom: 1.5rem;
        }
        .alert ul { margin: 0; padding-left: 1.5rem; }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.8125rem;
            margin-top: 2rem;
            transition: color 0.2s;
            animation: fadeUp 0.8s ease-out 0.2s forwards;
            opacity: 0;
        }
        .back-link:hover { color: white; }

        /* Animations */
        @keyframes authLogoEnter {
            from { opacity: 0; transform: scale(0.7) translateY(-20px); filter: drop-shadow(0 0 0px transparent); }
            to { opacity: 1; transform: scale(1) translateY(0); filter: drop-shadow(0 0 25px rgba(99, 102, 241, 0.6)) drop-shadow(0 0 50px rgba(59, 130, 246, 0.3)); }
        }
        @keyframes authLogoFloat {
            0%, 100% { transform: scale(1) translateY(0); filter: drop-shadow(0 0 25px rgba(99, 102, 241, 0.6)) drop-shadow(0 0 50px rgba(59, 130, 246, 0.3)); }
            50% { transform: scale(1.05) translateY(-8px); filter: drop-shadow(0 0 35px rgba(99, 102, 241, 0.8)) drop-shadow(0 0 70px rgba(59, 130, 246, 0.4)); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleUp {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
    </style>
</head>
<body>
    <div class="glow-effect"></div>
    
    <div class="auth-wrapper">
        <a href="{{ route('home') }}" class="auth-brand">
            <img src="{{ asset('images/lg.png') }}" alt="Scholarchive Logo">
        </a>

        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:24px;height:24px;"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                </div>
                <h2 class="auth-title">Selamat Datang Kembali</h2>
                <p class="auth-subtitle">Masuk untuk melanjutkan ke dashboard Anda.</p>
            </div>

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                @if($errors->any())
                    <div class="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label class="form-label" for="login-email">Email Sekolah / Admin</label>
                    <input type="email" name="email" class="form-control" id="login-email" placeholder="nama@school.edu" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="login-password">Kata Sandi</label>
                    <input type="password" name="password" class="form-control" id="login-password" placeholder="••••••••" required>
                </div>
                <div class="checkbox-row">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" class="custom-checkbox"> Ingat saya
                    </label>
                    <a href="#" class="auth-link">Lupa kata sandi?</a>
                </div>
                <button type="submit" class="btn-submit">Masuk</button>
            </form>

            <div class="auth-footer">
                Belum punya akun? <a href="{{ route('register') }}" class="auth-link">Daftar di sini</a>
            </div>
        </div>

        <div style="text-align:center;">
            <a href="{{ route('home') }}" class="back-link">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
