@extends('layouts.app')
@section('title', 'Pengaturan Akun — Scholarchive')

@section('content')
<section class="dk-page">
    <div class="dk-arc"></div>
    <div class="container" style="max-width:700px;position:relative;z-index:1;">
        <a href="{{ route('student.profile') }}" class="dk-back-link animate-item delay-1">← Kembali ke Profil</a>

        {{-- Success Alert --}}
        @if(session('success'))
        <div class="dk-alert-success animate-item delay-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:20px;height:20px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- Page Title --}}
        <div class="animate-item delay-2" style="margin-bottom:2rem;">
            <h2 style="font-size:1.75rem;font-weight:800;color:#f1f5f9;margin:0 0 0.375rem;">Pengaturan Akun</h2>
            <p style="color:#94a3b8;font-size:0.9375rem;margin:0;">Kelola email dan password akun Anda</p>
        </div>

        {{-- Email Section --}}
        <div class="dk-card animate-item delay-3" style="margin-bottom:1.5rem;">
            <div class="dk-section-header">
                <div class="dk-section-icon" style="background:rgba(59,130,246,0.15);color:#60a5fa;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                </div>
                <div>
                    <h3 class="dk-section-title">Alamat Email</h3>
                    <p class="dk-section-desc">Email yang digunakan untuk login ke akun Anda</p>
                </div>
            </div>
            <form action="{{ route('student.settings.update') }}" method="POST" onsubmit="document.getElementById('real_email').value = document.getElementById('email_username').value + '@siswa.skagata.sch.id'">
                @csrf
                @method('PUT')
                <input type="hidden" name="section" value="email">
                <input type="hidden" name="email" id="real_email">
                <div class="dk-form-group">
                    <label class="dk-label">Email Saat Ini</label>
                    <div class="dk-current-value">{{ $user->email }}</div>
                </div>
                <div class="dk-form-group">
                    <label class="dk-label">Email Baru</label>
                    @php
                        $currentEmail = old('email', $user->email);
                        $usernamePart = explode('@', $currentEmail)[0];
                    @endphp
                    <div style="display:flex; align-items:center;">
                        <input type="text" id="email_username" class="dk-input" style="border-top-right-radius:0; border-bottom-right-radius:0; border-right:none; flex:1;" placeholder="nama.siswa" value="{{ $usernamePart }}" required>
                        <div style="padding:0.75rem 1rem; background:rgba(15,23,42,0.8); border:1.5px solid rgba(148,163,184,0.12); border-left:none; border-top-right-radius:0.625rem; border-bottom-right-radius:0.625rem; color:#94a3b8; font-size:0.875rem;">
                            @siswa.skagata.sch.id
                        </div>
                    </div>
                    @error('email')
                        <span class="dk-error-text">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="dk-btn-primary dk-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    Simpan Email
                </button>
            </form>
        </div>

        {{-- Password Section --}}
        <div class="dk-card animate-item delay-4">
            <div class="dk-section-header">
                <div class="dk-section-icon" style="background:rgba(139,92,246,0.15);color:#a78bfa;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                </div>
                <div>
                    <h3 class="dk-section-title">Ubah Password</h3>
                    <p class="dk-section-desc">Pastikan password baru Anda kuat dan mudah diingat</p>
                </div>
            </div>
            <form action="{{ route('student.settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="section" value="password">
                <div class="dk-form-group">
                    <label class="dk-label">Password Lama</label>
                    <div class="dk-password-wrap">
                        <input type="password" name="current_password" class="dk-input" placeholder="Masukkan password lama" id="current_password">
                        <button type="button" class="dk-eye-btn" onclick="togglePassword('current_password', this)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </button>
                    </div>
                    @error('current_password')
                        <span class="dk-error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="dk-form-group">
                    <label class="dk-label">Password Baru</label>
                    <div class="dk-password-wrap">
                        <input type="password" name="password" class="dk-input" placeholder="Minimal 8 karakter" id="new_password">
                        <button type="button" class="dk-eye-btn" onclick="togglePassword('new_password', this)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="dk-error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="dk-form-group">
                    <label class="dk-label">Konfirmasi Password Baru</label>
                    <div class="dk-password-wrap">
                        <input type="password" name="password_confirmation" class="dk-input" placeholder="Ketik ulang password baru" id="confirm_password">
                        <button type="button" class="dk-eye-btn" onclick="togglePassword('confirm_password', this)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </button>
                    </div>
                </div>
                <button type="submit" class="dk-btn-primary dk-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                    Ubah Password
                </button>
            </form>
        </div>
    </div>
</section>

<style>
/* ===== SHARED DARK PAGE ===== */
.dk-page {
    background: linear-gradient(180deg, #0b0f1a 0%, #111827 40%, #0f172a 100%);
    min-height: 100vh;
    padding: 2rem 0 4rem;
    position: relative;
    overflow: hidden;
}
.dk-arc {
    position: absolute;
    top: -350px;
    left: 50%;
    transform: translateX(-50%);
    width: 900px;
    height: 900px;
    border-radius: 50%;
    border: 1px solid rgba(99, 102, 241, 0.1);
    pointer-events: none;
}
.dk-arc::before {
    content: '';
    position: absolute;
    bottom: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 700px;
    height: 700px;
    border-radius: 50%;
    border: 1px solid rgba(99, 102, 241, 0.06);
}
.dk-back-link {
    display: inline-block;
    font-size: 0.875rem;
    color: #818cf8;
    margin-bottom: 1rem;
    text-decoration: none;
    transition: color 0.15s;
}
.dk-back-link:hover { color: #a5b4fc; }

.dk-card {
    background: rgba(30, 41, 59, 0.5);
    border: 1px solid rgba(148, 163, 184, 0.08);
    border-radius: 1rem;
    padding: 2rem;
    backdrop-filter: blur(12px);
}
.dk-card-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #f1f5f9;
    margin-bottom: 1.5rem;
}

/* Settings specific */
.dk-settings-icon {
    width: 48px;
    height: 48px;
    border-radius: 0.75rem;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.2));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #818cf8;
    flex-shrink: 0;
}

.dk-section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid rgba(148, 163, 184, 0.08);
}
.dk-section-icon {
    width: 40px;
    height: 40px;
    border-radius: 0.625rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.dk-section-title {
    font-size: 1.0625rem;
    font-weight: 700;
    color: #f1f5f9;
    margin: 0 0 0.125rem;
}
.dk-section-desc {
    font-size: 0.8125rem;
    color: #64748b;
    margin: 0;
}

.dk-form-group {
    margin-bottom: 1.25rem;
}
.dk-label {
    display: block;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #cbd5e1;
    margin-bottom: 0.375rem;
}
.dk-input {
    width: 100%;
    background: rgba(15, 23, 42, 0.6);
    border: 1.5px solid rgba(148, 163, 184, 0.12);
    border-radius: 0.625rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    color: #e2e8f0;
    font-family: 'Poppins', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.dk-input::placeholder { color: rgba(148, 163, 184, 0.45); }
.dk-input:focus {
    outline: none;
    border-color: rgba(99, 102, 241, 0.5);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    background: rgba(15, 23, 42, 0.8);
}

.dk-current-value {
    background: rgba(15, 23, 42, 0.4);
    border: 1.5px solid rgba(148, 163, 184, 0.08);
    border-radius: 0.625rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    color: #94a3b8;
    font-family: 'Poppins', sans-serif;
}

.dk-password-wrap {
    position: relative;
}
.dk-password-wrap .dk-input {
    padding-right: 3rem;
}
.dk-eye-btn {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #64748b;
    cursor: pointer;
    padding: 0.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s;
}
.dk-eye-btn:hover { color: #e2e8f0; }

.dk-error-text {
    display: block;
    margin-top: 0.375rem;
    font-size: 0.8125rem;
    color: #fca5a5;
}

.dk-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff;
    padding: 0.75rem 1.5rem;
    border-radius: 0.625rem;
    font-weight: 600;
    font-size: 0.875rem;
    border: none;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    transition: all 0.2s;
    text-decoration: none;
}
.dk-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
}
.dk-btn-sm {
    padding: 0.625rem 1.25rem;
    font-size: 0.8125rem;
}

.dk-alert-success {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(16, 185, 129, 0.2);
    color: #34d399;
    padding: 1rem 1.25rem;
    border-radius: 0.75rem;
    margin-bottom: 1.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    backdrop-filter: blur(8px);
}

/* Animations */
.animate-item {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeUp 0.6s ease forwards;
}
.delay-1 { animation-delay: 0.05s; }
.delay-2 { animation-delay: 0.1s; }
.delay-3 { animation-delay: 0.15s; }
.delay-4 { animation-delay: 0.2s; }
@keyframes fadeUp {
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
    .dk-page { padding: 1.5rem 0 3rem; }
    .dk-card { padding: 1.5rem; }
    .dk-arc { width: 600px; height: 600px; top: -250px; }
}
</style>

<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>';
    } else {
        input.type = 'password';
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>';
    }
}
</script>
@endsection
