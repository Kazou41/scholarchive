<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Siswa — Scholarchive</title>
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
            padding: 2rem 0; /* extra padding for taller form */
        }

        /* Top radial glow */
        .glow-effect {
            position: fixed;
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
            max-width: 460px; /* slightly wider for register */
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
            margin-top: 1rem;
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

        .domain-hint {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.375rem;
            line-height: 1.5;
        }

        /* Email Input Group with Domain Suffix */
        .email-input-group {
            display: flex;
            position: relative;
        }
        .email-input-group .form-control {
            border-radius: 0.625rem 0 0 0.625rem;
            border-right: none;
            flex: 1;
        }
        .email-input-group .form-control:focus {
            z-index: 2;
        }
        .email-domain-btn {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            background: rgba(99, 102, 241, 0.12);
            border: 1px solid var(--input-border);
            border-left: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 0 0.625rem 0.625rem 0;
            padding: 0 0.875rem;
            color: #818cf8;
            font-size: 0.8125rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
            position: relative;
        }
        .email-domain-btn:hover {
            background: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
        }
        .email-domain-btn svg {
            width: 12px;
            height: 12px;
            transition: transform 0.2s;
        }
        .email-domain-btn.open svg {
            transform: rotate(180deg);
        }
        .email-domain-dropdown {
            position: absolute;
            top: calc(100% + 4px);
            right: 0;
            min-width: 220px;
            background: rgba(22, 27, 43, 0.95);
            border: 1px solid rgba(148, 163, 184, 0.15);
            border-radius: 0.625rem;
            padding: 0.375rem;
            backdrop-filter: blur(16px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
            z-index: 20;
            display: none;
        }
        .email-domain-dropdown.show {
            display: block;
            animation: dropIn 0.15s ease-out;
        }
        .email-domain-option {
            display: block;
            width: 100%;
            background: none;
            border: none;
            text-align: left;
            padding: 0.5rem 0.75rem;
            font-size: 0.8125rem;
            font-family: inherit;
            color: #e2e8f0;
            cursor: pointer;
            border-radius: 0.375rem;
            transition: all 0.15s;
        }
        .email-domain-option:hover {
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
        }
        .email-domain-option.active {
            background: rgba(99, 102, 241, 0.2);
            color: #818cf8;
            font-weight: 600;
        }
        @keyframes dropIn {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:24px;height:24px;"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
                </div>
                <h2 class="auth-title">Buat Akun Siswa</h2>
                <p class="auth-subtitle">Daftar menggunakan email sekolah Anda.</p>
            </div>

            <form action="{{ route('register.submit') }}" method="POST">
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
                    <label class="form-label" for="reg-name">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" id="reg-name" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="reg-email-user">Email Sekolah</label>
                    <input type="hidden" name="email" id="reg-email-hidden" value="{{ old('email') }}">
                    <div class="email-input-group">
                        <input type="text" class="form-control" id="reg-email-user" placeholder="nama.kamu" required autocomplete="off">
                        <div class="email-domain-btn" id="domain-toggle" onclick="toggleDomainDropdown()">
                            <span id="domain-label">@siswa.skagata.sch.id</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                            <div class="email-domain-dropdown" id="domain-dropdown">
                                <button type="button" class="email-domain-option active" onclick="selectDomain('@siswa.skagata.sch.id', this)">@siswa.skagata.sch.id</button>
                            </div>
                        </div>
                    </div>
                    <div class="domain-hint">
                        Gunakan email sekolah resmi yang sudah terdaftar.
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="reg-password">Kata Sandi</label>
                    <input type="password" name="password" class="form-control" id="reg-password" placeholder="Minimal 8 karakter" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="reg-password-confirm">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" class="form-control" id="reg-password-confirm" placeholder="Ulangi kata sandi" required>
                </div>

                <button type="submit" class="btn-submit">Daftar Sekarang</button>
            </form>

            <div class="auth-footer">
                Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a>
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

<script>
    var currentDomain = '@siswa.skagata.sch.id';

    function toggleDomainDropdown() {
        var dd = document.getElementById('domain-dropdown');
        var btn = document.getElementById('domain-toggle');
        dd.classList.toggle('show');
        btn.classList.toggle('open');
    }

    function selectDomain(domain, el) {
        currentDomain = domain;
        document.getElementById('domain-label').textContent = domain;
        document.querySelectorAll('.email-domain-option').forEach(function(o) { o.classList.remove('active'); });
        el.classList.add('active');
        document.getElementById('domain-dropdown').classList.remove('show');
        document.getElementById('domain-toggle').classList.remove('open');
    }

    document.addEventListener('click', function(e) {
        var btn = document.getElementById('domain-toggle');
        if (btn && !btn.contains(e.target)) {
            document.getElementById('domain-dropdown').classList.remove('show');
            btn.classList.remove('open');
        }
    });

    document.querySelector('form').addEventListener('submit', function(e) {
        var username = document.getElementById('reg-email-user').value.trim();
        document.getElementById('reg-email-hidden').value = username + currentDomain;
    });

    (function() {
        var oldEmail = document.getElementById('reg-email-hidden').value;
        if (oldEmail && oldEmail.indexOf('@') !== -1) {
            var parts = oldEmail.split('@');
            document.getElementById('reg-email-user').value = parts[0];
            var domainPart = '@' + parts[1];
            currentDomain = domainPart;
            document.getElementById('domain-label').textContent = domainPart;
            document.querySelectorAll('.email-domain-option').forEach(function(o) {
                if (o.textContent.trim() === domainPart) o.classList.add('active');
                else o.classList.remove('active');
            });
        }
    })();
</script>
</html>
