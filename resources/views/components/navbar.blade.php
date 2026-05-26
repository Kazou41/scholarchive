<style>
.nav-btn-modern {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    border-radius: 999px;
    font-size: 0.8125rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-family: 'Poppins', sans-serif;
}
.nav-btn-upload {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.1);
}
.nav-btn-upload:hover {
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
    transform: translateY(-2px);
    color: #ffffff !important;
}
.nav-btn-cv {
    background: rgba(15, 23, 42, 0.05);
    color: #475569 !important;
    border: 1px solid rgba(15, 23, 42, 0.1);
    backdrop-filter: blur(8px);
}
.nav-btn-cv:hover {
    background: rgba(15, 23, 42, 0.1);
    color: #0f172a !important;
    border-color: rgba(15, 23, 42, 0.2);
}
.navbar-dark .nav-btn-cv {
    background: rgba(148, 163, 184, 0.1);
    color: #e2e8f0 !important;
    border: 1px solid rgba(148, 163, 184, 0.15);
}
.navbar-dark .nav-btn-cv:hover {
    background: rgba(148, 163, 184, 0.2);
    color: #ffffff !important;
    border-color: rgba(148, 163, 184, 0.3);
}
.nav-btn-login {
    background: linear-gradient(135deg, #2563eb, #4f46e5);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.1);
}
.nav-btn-login:hover {
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    transform: translateY(-2px);
    color: #ffffff !important;
}
</style>
@php $isDark = request()->routeIs('home') || request()->routeIs('help') || request()->routeIs('portfolio.*') || request()->routeIs('student.portfolio.*') || request()->routeIs('student.generate-cv') || request()->routeIs('student.public-profile') || request()->routeIs('student.profile') || request()->routeIs('student.profile.edit'); @endphp
<nav class="navbar {{ $isDark ? 'navbar-dark' : '' }}">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="{{ asset('images/logo-white.png') }}" alt="Scholarchive" style="height:30px;{{ $isDark ? '' : 'filter:brightness(0) saturate(100%) invert(15%) sepia(90%) saturate(3000%) hue-rotate(215deg) brightness(90%);' }}">
        </a>
        <div class="navbar-links">
            <a href="{{ route('home') }}#home" class="nav-scroll-link" data-section="home">Beranda</a>
            <a href="{{ route('home') }}#featured" class="nav-scroll-link" data-section="featured">Karya Pilihan</a>
            <a href="{{ route('home') }}#about" class="nav-scroll-link" data-section="about">Tentang Kami</a>
            <a href="{{ route('home') }}#generate-cv" class="nav-scroll-link" data-section="generate-cv">Buat CV</a>
            <a href="{{ route('portfolio.search') }}" class="{{ request()->routeIs('portfolio.*') ? 'active' : '' }}">Portofolio</a>
            <a href="{{ route('help') }}" class="{{ request()->routeIs('help') ? 'active' : '' }}">Bantuan</a>
        </div>
        <div class="navbar-actions">
            @auth
                @if(auth()->user()->isStudent())
                    <a href="{{ route('student.portfolio.create') }}" class="nav-btn-modern nav-btn-upload">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Unggah Karya
                    </a>
                    <a href="{{ route('student.generate-cv') }}" class="nav-btn-modern nav-btn-cv">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        Buat CV
                    </a>
                @endif
                <div class="dropdown">
                    <button class="topbar-icon" data-dropdown style="border:2px solid {{ $isDark ? '#6366f1' : 'var(--primary)' }};border-radius:var(--radius-full);width:36px;height:36px;background:{{ $isDark ? 'rgba(30,41,59,0.8)' : '#fff' }};cursor:pointer;padding:0;overflow:hidden;display:flex;align-items:center;justify-content:center;">
                        @if(auth()->user()->isStudent() && auth()->user()->studentProfile && auth()->user()->studentProfile->photo)
                            <img src="{{ asset('storage/' . auth()->user()->studentProfile->photo) }}" style="width:100%;height:100%;object-fit:cover;" alt="Profile">
                        @else
                            <span style="font-weight:600;font-size:0.8125rem;color:{{ $isDark ? '#a5b4fc' : 'var(--primary)' }};text-transform:uppercase;">
                                {{ substr(auth()->user()->name, 0, 2) }}
                            </span>
                        @endif
                    </button>
                    <div class="dropdown-menu">
                        <div style="padding:0.625rem 0.875rem;border-bottom:1px solid rgba(255,255,255,0.06);margin-bottom:0.375rem;">
                            <div style="font-weight:600;color:#fff;font-size:0.875rem;">{{ auth()->user()->name }}</div>
                            <div style="font-size:0.75rem;color:rgba(255,255,255,0.4);">{{ auth()->user()->email }}</div>
                        </div>
                        
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('student.profile') }}" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                Profil
                            </a>
                            <a href="{{ route('student.portfolio.create') }}" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                Unggah Karya
                            </a>
                            <a href="{{ route('student.generate-cv') }}" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/></svg>
                                Buat CV
                            </a>
                        @endif
                        
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="dropdown-item danger" style="width:100%;text-align:left;border:none;background:none;cursor:pointer;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="nav-btn-modern nav-btn-login">
                    Masuk
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            @endauth
        </div>
    </div>
</nav>
