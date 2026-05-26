@extends('layouts.app')
@section('title', 'Scholarchive — Portofolio Digital Siswa & Generator CV')

@section('content')
{{-- Hero Section --}}
<section class="hp-hero" id="home">
    <div class="hp-hero-arc"></div>
    <div class="hp-hero-inner">
        <h1 class="hp-hero-title scroll-reveal reveal-up">
            Simpan Karyamu, Bangun Portofoliomu<br>dengan <span class="hp-hero-accent">Scholarchive</span>
        </h1>
        <p class="hp-hero-desc scroll-reveal reveal-up" style="transition-delay: 0.1s;">
            Dokumentasikan karya, tunjukkan potensi, dan siapkan masa depanmu dalam satu platform digital.
        </p>
        <div class="hp-hero-actions scroll-reveal reveal-up" style="transition-delay: 0.2s;">
            <a href="{{ route('login') }}" class="hp-btn-primary">Mulai Sekarang</a>
        </div>
    </div>
</section>

{{-- Featured Gallery Section --}}
<section class="hp-gallery" id="featured">
    <div class="hp-section-inner">
        <div class="hp-section-header scroll-reveal reveal-down">
            <h2>Galeri Pilihan</h2>
            <p>Berikut adalah portofolio hasil karya siswa yang paling direkomendasikan</p>
        </div>
        <div class="hp-gallery-grid">
            @forelse($featuredWorks->take(4) as $index => $work)
            <a href="{{ route('portfolio.detail', $work->slug) }}" class="hp-gallery-card scroll-reveal reveal-up" style="transition-delay: {{ $index * 0.1 }}s;">
                <div class="hp-gallery-img">
                    @if($work->file_path && $work->file_type && str_starts_with($work->file_type, 'image/'))
                        <img src="{{ asset('storage/' . $work->file_path) }}" alt="{{ $work->title }}">
                    @else
                        <div class="hp-gallery-placeholder">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" style="width:40px;height:40px;opacity:0.3;"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                        </div>
                    @endif
                    <button class="hp-gallery-share" onclick="shareWork(event, '{{ addslashes($work->title) }}', '{{ route('portfolio.detail', $work->slug) }}');" title="Bagikan Karya">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z"/></svg>
                    </button>
                </div>
                <div class="hp-gallery-body">
                    <h3 class="hp-gallery-title">{{ $work->title }}</h3>
                    <p class="hp-gallery-meta">
                        {{ $work->student->name ?? 'Tidak diketahui' }} · {{ $work->student->studentProfile->class_name ?? '' }}
                    </p>
                    @if($work->categories->isNotEmpty())
                        <span class="hp-gallery-badge">{{ $work->categories->first()->name }}</span>
                    @endif
                </div>
            </a>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; color: #64748b; padding: 3rem;">
                <p>Belum ada karya pilihan yang ditampilkan.</p>
            </div>
            @endforelse
        </div>
        <div style="text-align:center;margin-top:2.5rem;">
            <a href="{{ route('portfolio.search') }}" class="hp-btn-outline">Lihat Lainnya</a>
        </div>
    </div>
</section>

{{-- About Section --}}
<section class="hp-about" id="about">
    <div class="hp-section-inner">
        <div class="hp-about-grid">
            <div class="hp-about-visual scroll-reveal reveal-right" id="about-logo-wrap">
                <div class="hp-about-logo-glow"></div>
                <img src="{{ asset('images/logotokputih.png') }}" alt="Scholarchive Logo" class="hp-about-logo-img" id="about-logo-img">
            </div>
            <div class="hp-about-content scroll-reveal reveal-left">
                <h2 class="hp-about-title">Tentang</h2>
                <p>
                    <strong style="color:#e2e8f0;">Scholarchive</strong> adalah platform portofolio digital yang dirancang untuk
                    membantu siswa dalam menyimpan dan mengelola karya akademis mereka secara profesional.
                    Melalui Scholarchive, siswa dapat mengelola portofolio personal, mendokumentasikan
                    proyek, karya, dan pencapaian akademis, yang berguna untuk
                    keperluan pendidikan dan karier di masa depan.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- CTA Generate CV --}}
<section class="hp-cta" id="generate-cv">
    <div class="hp-section-inner">
        <div class="hp-cta-glow scroll-reveal reveal-scale">
            <div class="hp-cta-glow-orb hp-cta-glow-orb-1"></div>
            <div class="hp-cta-glow-orb hp-cta-glow-orb-2"></div>
            <div class="hp-cta-glow-orb hp-cta-glow-orb-3"></div>
            <div class="hp-cta-card">
                <div class="hp-cta-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:28px;height:28px;color:#fff;"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/></svg>
                </div>
                <h2 class="hp-cta-title">Bangun Masa Depanmu dengan AI</h2>
                <p class="hp-cta-desc">
                    Buat CV profesional secara otomatis yang disesuaikan dengan kebutuhan lamaran kerja
                    menggunakan data terverifikasi dari portofolio Scholarchive-mu.
                </p>
                <a href="{{ auth()->check() && auth()->user()->isStudent() ? route('student.generate-cv') : route('register') }}" class="hp-cta-btn">
                    ✦ Buat CV Kamu
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* ========== HOME PAGE DARK THEME ========== */

/* === HERO === */
.hp-hero {
    background: linear-gradient(180deg, #070b14 0%, #0d1321 50%, #111827 100%);
    padding: 6rem 2rem 8rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.hp-hero-arc {
    position: absolute;
    bottom: -350px;
    left: 50%;
    transform: translateX(-50%);
    width: 900px;
    height: 900px;
    border-radius: 50%;
    border: 1px solid rgba(99, 102, 241, 0.15);
    pointer-events: none;
}
.hp-hero-arc::before {
    content: '';
    position: absolute;
    bottom: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 700px;
    height: 700px;
    border-radius: 50%;
    border: 1px solid rgba(99, 102, 241, 0.08);
}
.hp-hero-inner {
    max-width: 720px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}
.hp-hero-title {
    font-size: 3rem;
    font-weight: 800;
    color: #f1f5f9;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    letter-spacing: -0.02em;
}
.hp-hero-accent {
    background: linear-gradient(135deg, #6366f1, #818cf8, #a78bfa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.hp-hero-desc {
    color: #94a3b8;
    font-size: 1rem;
    line-height: 1.8;
    max-width: 540px;
    margin: 0 auto 2.5rem;
}
.hp-hero-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
}
.hp-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: #fff;
    padding: 0.8rem 2rem;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    transition: transform 0.2s, box-shadow 0.2s;
}
.hp-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
    color: #fff;
}
.hp-btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #cbd5e1;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    transition: color 0.2s;
}
.hp-btn-ghost:hover { color: #818cf8; }
.hp-btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #818cf8;
    border: 1.5px solid rgba(99, 102, 241, 0.4);
    padding: 0.65rem 1.75rem;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.2s;
}
.hp-btn-outline:hover {
    background: rgba(99, 102, 241, 0.1);
    border-color: #6366f1;
    color: #a5b4fc;
}

/* === SHARED === */
.hp-section-inner {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 2rem;
}
.hp-section-header {
    text-align: center;
    margin-bottom: 3rem;
}
.hp-section-header h2 {
    font-size: 1.75rem;
    font-weight: 800;
    color: #f1f5f9;
    margin-bottom: 0.5rem;
}
.hp-section-header p {
    color: #64748b;
    font-size: 0.95rem;
}

/* === GALLERY === */
.hp-gallery {
    background: linear-gradient(180deg, #111827 0%, #0f172a 100%);
    padding: 5rem 2rem;
}
.hp-gallery-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}
.hp-gallery-card {
    background: rgba(30, 41, 59, 0.5);
    border: 1px solid rgba(148, 163, 184, 0.1);
    border-radius: 1rem;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
}
.hp-gallery-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
    border-color: rgba(99, 102, 241, 0.3);
}
.hp-gallery-img {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: rgba(15, 23, 42, 0.6);
}
.hp-gallery-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.35s;
}
.hp-gallery-card:hover .hp-gallery-img img {
    transform: scale(1.05);
}
.hp-gallery-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #475569;
}
.hp-gallery-share {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1px solid rgba(148, 163, 184, 0.2);
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    cursor: pointer;
    transition: all 0.2s;
}
.hp-gallery-share:hover {
    background: rgba(99, 102, 241, 0.3);
    color: #fff;
}
.hp-gallery-body {
    padding: 1.25rem;
}
.hp-gallery-title {
    font-size: 1rem;
    font-weight: 700;
    color: #e2e8f0;
    margin-bottom: 0.375rem;
}
.hp-gallery-meta {
    font-size: 0.8125rem;
    color: #64748b;
    margin-bottom: 0.625rem;
}
.hp-gallery-badge {
    display: inline-block;
    padding: 0.2rem 0.65rem;
    border-radius: 999px;
    font-size: 0.7rem;
    font-weight: 600;
    background: rgba(99, 102, 241, 0.15);
    color: #818cf8;
    border: 1px solid rgba(99, 102, 241, 0.2);
}

/* === ABOUT === */
.hp-about {
    background: linear-gradient(180deg, #0f172a 0%, #111827 100%);
    padding: 5rem 2rem;
}
.hp-about-grid {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 4rem;
    align-items: center;
}
.hp-about-visual {
    border-radius: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    min-height: 300px;
}

/* Glow orb behind logo */
.hp-about-logo-glow {
    position: absolute;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.4) 0%, rgba(59, 130, 246, 0.2) 40%, transparent 70%);
    filter: blur(40px);
    opacity: 0;
    transform: scale(0.5);
    transition: opacity 0.8s ease, transform 1s ease, filter 0.8s ease;
    pointer-events: none;
}
.hp-about-visual.in-view .hp-about-logo-glow {
    opacity: 1;
    transform: scale(1.6);
    filter: blur(50px);
    animation: aboutGlowPulse 3s ease-in-out infinite;
}

/* Logo image */
.hp-about-logo-img {
    width: 180px;
    height: auto;
    position: relative;
    z-index: 1;
    opacity: 0.7;
    transform: scale(0.7);
    transition: opacity 0.8s ease 0.1s, transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s, filter 0.8s ease 0.1s;
    filter: drop-shadow(0 0 0px transparent);
}
.hp-about-visual.in-view .hp-about-logo-img {
    opacity: 1;
    transform: scale(1);
    filter: drop-shadow(0 0 30px rgba(99, 102, 241, 0.5)) drop-shadow(0 0 60px rgba(59, 130, 246, 0.25));
    animation: aboutLogoFloat 4s ease-in-out infinite 0.8s;
}

@keyframes aboutGlowPulse {
    0%, 100% { opacity: 0.7; transform: scale(1.5); }
    50% { opacity: 1; transform: scale(1.8); }
}
@keyframes aboutLogoFloat {
    0%, 100% { transform: scale(1) translateY(0); }
    50% { transform: scale(1.05) translateY(-10px); }
}

.hp-about-title {
    font-size: 2.25rem;
    font-weight: 800;
    color: #f1f5f9;
    margin-bottom: 1.25rem;
}
.hp-about-content p {
    color: #94a3b8;
    font-size: 0.95rem;
    line-height: 1.9;
}

/* === CTA === */
.hp-cta {
    background: linear-gradient(180deg, #111827 0%, #0a0e1a 100%);
    padding: 4rem 2rem 5rem;
}

/* Neon glow wrapper */
.hp-cta-glow {
    max-width: 700px;
    margin: 0 auto;
    position: relative;
    border-radius: 1.75rem;
    padding: 3px;
}

/* Neon orbs - hidden by default, visible on hover */
.hp-cta-glow-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    opacity: 0;
    transition: opacity 0.5s ease, transform 0.5s ease;
    pointer-events: none;
    z-index: 0;
}
.hp-cta-glow-orb-1 {
    width: 280px; height: 280px;
    background: rgba(99, 102, 241, 0.5);
    top: -80px; left: -60px;
}
.hp-cta-glow-orb-2 {
    width: 240px; height: 240px;
    background: rgba(168, 85, 247, 0.45);
    bottom: -70px; right: -50px;
}
.hp-cta-glow-orb-3 {
    width: 200px; height: 200px;
    background: rgba(59, 130, 246, 0.4);
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
}

/* Hover: reveal neon glow + animate */
.hp-cta-glow:hover .hp-cta-glow-orb { opacity: 1; }
.hp-cta-glow:hover .hp-cta-glow-orb-1 {
    animation: neonPulse1 3s ease-in-out infinite;
}
.hp-cta-glow:hover .hp-cta-glow-orb-2 {
    animation: neonPulse2 3.5s ease-in-out infinite;
}
.hp-cta-glow:hover .hp-cta-glow-orb-3 {
    animation: neonPulse3 4s ease-in-out infinite;
}

@keyframes neonPulse1 {
    0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.6; }
    50% { transform: translate(20px, 15px) scale(1.15); opacity: 1; }
}
@keyframes neonPulse2 {
    0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.5; }
    50% { transform: translate(-15px, -20px) scale(1.2); opacity: 1; }
}
@keyframes neonPulse3 {
    0%, 100% { transform: translate(-50%, -50%) scale(0.8); opacity: 0.3; }
    50% { transform: translate(-50%, -50%) scale(1.1); opacity: 0.7; }
}

/* Glassmorphism card */
.hp-cta-card {
    position: relative;
    z-index: 1;
    background: rgba(30, 41, 80, 0.35);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(129, 140, 248, 0.2);
    border-radius: 1.5rem;
    padding: 3.5rem 2.5rem;
    text-align: center;
    overflow: hidden;
    transition: border-color 0.4s ease, box-shadow 0.4s ease, transform 0.3s ease;
}
.hp-cta-glow:hover .hp-cta-card {
    border-color: rgba(129, 140, 248, 0.45);
    box-shadow:
        0 0 30px rgba(99, 102, 241, 0.15),
        0 0 60px rgba(139, 92, 246, 0.08),
        inset 0 1px 0 rgba(255,255,255,0.08);
    transform: translateY(-4px);
}

/* Inner shimmer on hover */
.hp-cta-card::before {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.04) 45%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.04) 55%, transparent 60%);
    transition: left 0.7s ease;
    z-index: 0;
}
.hp-cta-glow:hover .hp-cta-card::before {
    left: 100%;
}

.hp-cta-icon {
    width: 56px; height: 56px;
    border-radius: 0.75rem;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    position: relative;
    z-index: 1;
    transition: background 0.3s;
}
.hp-cta-glow:hover .hp-cta-icon {
    background: rgba(99, 102, 241, 0.25);
    border-color: rgba(129, 140, 248, 0.4);
}
.hp-cta-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 1rem;
    position: relative;
    z-index: 1;
}
.hp-cta-desc {
    color: rgba(255,255,255,0.7);
    font-size: 0.95rem;
    line-height: 1.7;
    max-width: 480px;
    margin: 0 auto 2rem;
    position: relative;
    z-index: 1;
}
.hp-cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255,255,255,0.95);
    color: #4338ca;
    padding: 0.8rem 2rem;
    border-radius: var(--radius-md);
    font-weight: 700;
    font-size: 0.95rem;
    text-decoration: none;
    transition: transform 0.2s, box-shadow 0.3s, background 0.3s;
    position: relative;
    z-index: 1;
}
.hp-cta-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 20px rgba(99, 102, 241, 0.4), 0 8px 25px rgba(0, 0, 0, 0.2);
    background: #fff;
    color: #4338ca;
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .hp-hero { padding: 4rem 1.5rem 5rem; }
    .hp-hero-title { font-size: 2rem; }
    .hp-hero-actions { flex-direction: column; gap: 1rem; }
    .hp-gallery-grid { grid-template-columns: 1fr; }
    .hp-about-grid { grid-template-columns: 1fr; gap: 2rem; }
    .hp-cta-card { padding: 2.5rem 1.5rem; }
    .hp-cta-title { font-size: 1.375rem; }
    .hp-cta-glow-orb { display: none; }
}

/* === SCROLL ANIMATIONS === */
.scroll-reveal {
    opacity: 0;
    transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    will-change: opacity, transform;
}
.reveal-up { transform: translateY(40px); }
.reveal-down { transform: translateY(-40px); }
.reveal-left { transform: translateX(40px); } /* Slide in from right */
.reveal-right { transform: translateX(-40px); } /* Slide in from left */
.reveal-scale { transform: scale(0.9); }

.scroll-reveal.visible {
    opacity: 1;
    transform: translate(0) scale(1);
}

/* Hero Arc Parallax Animation */
@keyframes hp-arc-breathe {
    0%, 100% { transform: translateX(-50%) translateY(0) scale(1); }
    50% { transform: translateX(-50%) translateY(-20px) scale(1.02); }
}
.hp-hero-arc {
    animation: hp-arc-breathe 8s ease-in-out infinite;
}

/* Share Toast Notification */
.share-toast {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    background: rgba(15, 23, 42, 0.9);
    border: 1px solid rgba(99, 102, 241, 0.4);
    color: #fff;
    padding: 0.875rem 1.25rem;
    border-radius: 0.75rem;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255,255,255,0.05);
    display: flex;
    align-items: center;
    gap: 0.625rem;
    font-size: 0.875rem;
    font-weight: 500;
    z-index: 10000;
    transform: translateY(100px);
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    pointer-events: none;
}
.share-toast.show {
    transform: translateY(0);
    opacity: 1;
}
</style>

<div class="share-toast" id="share-toast">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:18px;height:18px;color:#818cf8;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
    <span>Tautan karya berhasil disalin ke clipboard! 🔗</span>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Scroll Reveal Observer
    var revealElements = document.querySelectorAll('.scroll-reveal');
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: "0px 0px -50px 0px" });

        revealElements.forEach(function(el) {
            observer.observe(el);
        });
    } else {
        // Fallback for older browsers
        revealElements.forEach(function(el) {
            el.classList.add('visible');
        });
    }

    // Parallax effect on scroll for hero arc (in addition to keyframes)
    var heroArc = document.querySelector('.hp-hero-arc');
    if (heroArc) {
        window.addEventListener('scroll', function() {
            var scrollY = window.scrollY;
            if (scrollY < window.innerHeight) {
                heroArc.style.marginTop = (scrollY * 0.4) + 'px';
            }
        });
    }

    // Existing about logo animation
    var aboutVisual = document.getElementById('about-logo-wrap');
    if (aboutVisual && 'IntersectionObserver' in window) {
        var aboutObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    aboutVisual.classList.add('in-view');
                } else {
                    aboutVisual.classList.remove('in-view');
                }
            });
        }, { threshold: 0.3 });
        aboutObserver.observe(aboutVisual);
    }
});

// Global Share Work function for inline onclick triggers
window.shareWork = function(event, title, url) {
    event.preventDefault();
    event.stopPropagation();

    const toast = document.getElementById('share-toast');

    if (navigator.share) {
        navigator.share({
            title: title,
            url: url
        }).catch(err => console.log('Share cancelled or failed', err));
    } else {
        // Fallback to copying url to clipboard
        navigator.clipboard.writeText(url).then(function() {
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }, function(err) {
            console.error('Could not copy link to clipboard: ', err);
        });
    }
};
</script>
@endsection
