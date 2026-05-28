@extends('layouts.app')
@section('title', $user->name . ' — Scholarchive')

@section('content')
<section class="sp-page">
    <div class="sp-arc"></div>
    <div class="sp-arc sp-arc-2"></div>

    <div class="container" style="max-width:960px;position:relative;z-index:1;">
        {{-- Breadcrumb --}}
        <div class="sp-breadcrumb sp-fade-up">
            <a href="{{ route('portfolio.search') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Portofolio
            </a>
            <span class="sp-breadcrumb-sep">/</span>
            <span>Profil Siswa</span>
        </div>

        {{-- Profile Header with Banner --}}
        <div class="sp-profile-card sp-fade-up" style="padding:0;overflow:hidden;">
            {{-- Banner --}}
            @if($user->studentProfile && $user->studentProfile->banner)
            <div class="sp-banner">
                <img src="{{ asset('storage/' . $user->studentProfile->banner) }}" alt="Banner" class="sp-banner-img">
            </div>
            @else
            <div class="sp-banner sp-banner-default">
                <div class="sp-banner-shape" style="top:20px;right:60px;width:80px;height:80px;border-radius:50%;"></div>
                <div class="sp-banner-shape" style="top:60px;right:130px;width:40px;height:40px;border-radius:50%;"></div>
                <div class="sp-banner-shape" style="bottom:15px;left:38%;width:120px;height:120px;border-radius:50%;"></div>
                <div class="sp-banner-shape" style="top:25px;left:28%;width:55px;height:55px;border-radius:0.5rem;transform:rotate(15deg);"></div>
            </div>
            @endif

            {{-- Avatar + Info overlapping banner --}}
            <div class="sp-profile-body">
                <div class="sp-profile-row">
                    {{-- Avatar --}}
                    <div class="sp-avatar-wrap">
                        @if($user->studentProfile && $user->studentProfile->photo)
                            <img src="{{ asset('storage/' . $user->studentProfile->photo) }}" alt="Profile Photo" class="sp-avatar-img">
                        @else
                            <div class="sp-avatar-fallback">{{ substr($user->name, 0, 2) }}</div>
                        @endif
                    </div>
                    {{-- Name & Class --}}
                    <div style="padding-bottom:0.25rem;">
                        <h1 class="sp-name">{{ $user->name }}</h1>
                        @if($user->studentProfile)
                            <p class="sp-subtitle" style="margin:0;">{{ $user->studentProfile->class_name }} · {{ $user->studentProfile->major }}</p>
                        @endif
                    </div>
                </div>

                @if($user->studentProfile?->bio)
                <p class="sp-bio">{{ $user->studentProfile->bio }}</p>
                @endif

                {{-- Skills --}}
                <div class="sp-skills">
                    @foreach($user->skills as $skill)
                    <span class="sp-skill-tag">{{ $skill->name }}</span>
                    @endforeach
                </div>

                {{-- Contact Info --}}
                <div class="sp-contact-row">
                    <span class="sp-contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        {{ $user->email }}
                    </span>
                    @if($user->studentProfile?->address)
                    <span class="sp-contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 0115 0z"/></svg>
                        {{ $user->studentProfile->address }}
                    </span>
                    @endif
                    @if($user->studentProfile?->phone)
                    <span class="sp-contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                        {{ $user->studentProfile->phone }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Portfolio Section --}}
        <div class="sp-section-header sp-fade-up">
            <h2 class="sp-section-title">Karya <span style="color:#94a3b8;font-weight:400;">({{ $user->portfolios->count() }})</span></h2>
        </div>

        <div class="sp-portfolio-grid">
            @forelse($user->portfolios as $index => $work)
            <div class="sp-work-card sp-fade-up" style="transition-delay:{{ $index * 0.08 }}s;">
                <div class="sp-work-img" data-preview="{{ $work->file_path ? asset('storage/' . $work->file_path) : 'https://picsum.photos/seed/'.$work->id.'/1200/800' }}" data-title="{{ $work->title }}">
                    @if($work->file_path && str_starts_with($work->file_type, 'image/'))
                        <img src="{{ asset('storage/' . $work->file_path) }}" alt="{{ $work->title }}">
                    @elseif($work->file_type === 'application/pdf')
                        <div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#1e293b;color:#94a3b8;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:48px;height:48px;margin-bottom:0.5rem;"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            <span style="font-size:0.875rem;font-weight:600;">Dokumen PDF</span>
                        </div>
                    @elseif($work->video_url)
                        <div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#1e293b;color:#94a3b8;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:48px;height:48px;margin-bottom:0.5rem;"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 010 .656l-5.603 3.113a.375.375 0 01-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112z" /></svg>
                            <span style="font-size:0.875rem;font-weight:600;">Video Link</span>
                        </div>
                    @else
                        <img src="https://picsum.photos/seed/{{ $work->id }}/600/400" alt="{{ $work->title }}">
                    @endif
                    <div class="sp-work-overlay">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:28px;height:28px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9m11.25-5.25v4.5m0-4.5h-4.5m4.5 0L15 9m-11.25 11.25v-4.5m0 4.5h4.5m-4.5 0L9 15m11.25 5.25v-4.5m0 4.5h-4.5m4.5 0L15 15"/></svg>
                        <span>Preview</span>
                    </div>
                </div>
                <div class="sp-work-body">
                    <div class="sp-work-tags">
                        @foreach($work->categories->take(1) as $cat)
                            <span class="sp-tag sp-tag-primary">{{ $cat->name }}</span>
                        @endforeach
                        @if($work->latestAssessment)
                        <span class="sp-tag sp-tag-success">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                            Nilai: {{ $work->latestAssessment->score }}
                        </span>
                        @else
                        <span class="sp-tag sp-tag-warning">Menunggu</span>
                        @endif
                    </div>
                    <h3 class="sp-work-title">{{ $work->title }}</h3>
                    <a href="{{ route('portfolio.detail', $work->slug) }}" class="sp-work-link">
                        Lihat Detail
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="sp-empty">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:48px;height:48px;color:#475569;margin-bottom:1rem;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V4.5a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v15a1.5 1.5 0 001.5 1.5z"/></svg>
                <p style="color:#94a3b8;font-weight:500;">Belum ada karya yang diunggah.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Lightbox Preview --}}
<div class="sp-lightbox" id="sp-lightbox">
    <div class="sp-lightbox-backdrop"></div>
    <div class="sp-lightbox-content">
        <button class="sp-lightbox-close" id="sp-lightbox-close">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:24px;height:24px;"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <img id="sp-lightbox-img" src="" alt="Preview">
        <div class="sp-lightbox-title" id="sp-lightbox-title"></div>
    </div>
</div>

<style>
/* ===== STUDENT PROFILE DARK PAGE ===== */
.sp-page {
    background: linear-gradient(180deg, #0b0f1a 0%, #111827 40%, #0f172a 100%);
    min-height: 100vh;
    padding: 2rem 0 4rem;
    position: relative;
    overflow: hidden;
}

/* Decorative arcs */
.sp-arc {
    position: absolute;
    top: -400px;
    left: 50%;
    transform: translateX(-50%);
    width: 1000px;
    height: 1000px;
    border-radius: 50%;
    border: 1px solid rgba(99, 102, 241, 0.08);
    pointer-events: none;
}
.sp-arc-2 {
    width: 750px;
    height: 750px;
    top: -320px;
    border-color: rgba(99, 102, 241, 0.05);
}

/* Scroll animation */
.sp-fade-up {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}
.sp-fade-up.visible {
    opacity: 1;
    transform: translateY(0);
}

/* ===== PROFILE CARD ===== */
.sp-profile-card {
    background: rgba(30, 41, 59, 0.4);
    border: 1px solid rgba(148, 163, 184, 0.08);
    border-radius: 1.25rem;
    margin-bottom: 2rem;
    backdrop-filter: blur(16px);
}
.sp-profile-body {
    position: relative;
    padding: 0 2rem 1.75rem;
}

/* Banner */
.sp-banner {
    height: 180px;
    position: relative;
    overflow: hidden;
}
.sp-banner-img { width: 100%; height: 100%; object-fit: cover; display: block; }
.sp-banner-default {
    background: linear-gradient(135deg, #4338ca 0%, #6366f1 35%, #818cf8 65%, #a5b4fc 100%);
}
.sp-banner-shape {
    position: absolute;
    background: rgba(255, 255, 255, 0.07);
}

/* Profile row (avatar + name side by side) */
.sp-profile-row {
    display: flex;
    align-items: flex-end;
    gap: 1.5rem;
    margin-top: 0;
    margin-bottom: 1rem;
}
.sp-avatar-wrap {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid rgba(15, 23, 42, 0.9);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    flex-shrink: 0;
    margin-top: -55px;
}
.sp-avatar-img { width: 100%; height: 100%; object-fit: cover; }
.sp-avatar-fallback {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    background: rgba(99, 102, 241, 0.2);
    color: #818cf8;
    font-size: 2rem;
    font-weight: 700;
    text-transform: uppercase;
}
.sp-name {
    font-size: 1.5rem;
    font-weight: 800;
    color: #f1f5f9;
    margin-bottom: 0.125rem;
}
.sp-subtitle {
    color: #94a3b8;
    font-size: 0.9375rem;
}
.sp-bio {
    line-height: 1.7;
    color: #cbd5e1;
    font-size: 0.9375rem;
    margin-bottom: 1.25rem;
}

/* Skills */
.sp-skills {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-start;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}
.sp-skill-tag {
    padding: 0.3rem 0.75rem;
    background: rgba(99, 102, 241, 0.1);
    color: #a5b4fc;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
    border: 1px solid rgba(99, 102, 241, 0.15);
    transition: all 0.2s;
}
.sp-skill-tag:hover {
    background: rgba(99, 102, 241, 0.2);
    transform: translateY(-1px);
}

/* Contact */
.sp-contact-row {
    display: flex;
    gap: 1.25rem;
    justify-content: flex-start;
    flex-wrap: wrap;
}
.sp-contact-item {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.8125rem;
    color: #94a3b8;
}
.sp-contact-item svg { width: 16px; height: 16px; color: #64748b; }

/* ===== SECTION HEADER ===== */
.sp-section-header {
    margin-bottom: 1.25rem;
}
.sp-section-title {
    font-size: 1.375rem;
    font-weight: 700;
    color: #f1f5f9;
}

/* ===== PORTFOLIO GRID ===== */
.sp-portfolio-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.25rem;
}

/* Work Card */
.sp-work-card {
    background: rgba(30, 41, 59, 0.4);
    border: 1px solid rgba(148, 163, 184, 0.08);
    border-radius: 1rem;
    overflow: hidden;
    transition: all 0.3s ease;
    backdrop-filter: blur(8px);
}
.sp-work-card:hover {
    transform: translateY(-6px);
    border-color: rgba(99, 102, 241, 0.2);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 20px rgba(99, 102, 241, 0.05);
}

/* Work Image + Preview Overlay */
.sp-work-img {
    height: 200px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    background: rgba(15, 23, 42, 0.5);
}
.sp-work-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease, filter 0.4s ease;
}
.sp-work-card:hover .sp-work-img img {
    transform: scale(1.08);
    filter: brightness(0.6);
}
.sp-work-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    color: #fff;
    opacity: 0;
    transition: opacity 0.3s ease;
    font-size: 0.8125rem;
    font-weight: 600;
}
.sp-work-card:hover .sp-work-overlay { opacity: 1; }

/* Work Body */
.sp-work-body { padding: 1.25rem; }
.sp-work-tags { display: flex; gap: 0.375rem; flex-wrap: wrap; margin-bottom: 0.625rem; }
.sp-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.2rem 0.625rem;
    border-radius: 999px;
    font-size: 0.6875rem;
    font-weight: 600;
}
.sp-tag-primary { background: rgba(99, 102, 241, 0.15); color: #818cf8; }
.sp-tag-success { background: rgba(16, 185, 129, 0.15); color: #34d399; }
.sp-tag-warning { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }

.sp-work-title {
    font-size: 1rem;
    font-weight: 700;
    color: #f1f5f9;
    margin-bottom: 0.5rem;
}
.sp-work-link {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #818cf8;
    text-decoration: none;
    transition: all 0.2s;
}
.sp-work-link:hover { color: #a5b4fc; gap: 0.625rem; }

/* Empty state */
.sp-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
}

/* ===== LIGHTBOX ===== */
.sp-lightbox {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.35s ease, visibility 0.35s ease;
}
.sp-lightbox.active {
    opacity: 1;
    visibility: visible;
}
.sp-lightbox-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
.sp-lightbox-content {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    transform: scale(0.9) translateY(20px);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.sp-lightbox.active .sp-lightbox-content {
    transform: scale(1) translateY(0);
}
.sp-lightbox-content img {
    max-width: 90vw;
    max-height: 82vh;
    object-fit: contain;
    border-radius: 0.75rem;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
}
.sp-lightbox-close {
    position: absolute;
    top: -50px;
    right: 0;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #fff;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}
.sp-lightbox-close:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: rotate(90deg);
}
.sp-lightbox-title {
    margin-top: 1rem;
    font-size: 0.9375rem;
    font-weight: 600;
    color: #e2e8f0;
}

@media (max-width: 768px) {
    .sp-profile-body { padding: 0 1.25rem 1.5rem; }
    .sp-profile-row { flex-direction: column; align-items: center; text-align: center; }
    .sp-name { font-size: 1.375rem; }
    .sp-bio { text-align: center; }
    .sp-skills, .sp-contact-row { justify-content: center; }
    .sp-arc { width: 600px; height: 600px; top: -280px; }
    .sp-arc-2 { width: 450px; height: 450px; top: -200px; }
    .sp-contact-row { flex-direction: column; align-items: center; gap: 0.5rem; }
    .sp-portfolio-grid { grid-template-columns: 1fr; }
}

/* ===== BREADCRUMB ===== */
.sp-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #64748b;
    margin-bottom: 1.5rem;
}
.sp-breadcrumb a {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    color: #818cf8;
    text-decoration: none;
    transition: color 0.15s ease;
}
.sp-breadcrumb a:hover {
    color: #a5b4fc;
}
.sp-breadcrumb-sep {
    color: #475569;
}
.sp-breadcrumb span:last-child {
    color: #94a3b8;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== Scroll animation =====
    var fadeEls = document.querySelectorAll('.sp-fade-up');
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    fadeEls.forEach(function(el) { observer.observe(el); });

    // ===== Lightbox Preview =====
    var lightbox = document.getElementById('sp-lightbox');
    var lightboxImg = document.getElementById('sp-lightbox-img');
    var lightboxTitle = document.getElementById('sp-lightbox-title');
    var closeBtn = document.getElementById('sp-lightbox-close');
    var backdrop = lightbox.querySelector('.sp-lightbox-backdrop');

    // Open lightbox on image click
    document.querySelectorAll('.sp-work-img[data-preview]').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var src = this.getAttribute('data-preview');
            var title = this.getAttribute('data-title');
            lightboxImg.src = src;
            lightboxTitle.textContent = title;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Close lightbox
    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
        setTimeout(function() { lightboxImg.src = ''; }, 350);
    }
    closeBtn.addEventListener('click', closeLightbox);
    backdrop.addEventListener('click', closeLightbox);
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && lightbox.classList.contains('active')) closeLightbox();
    });
});
</script>
@endsection
