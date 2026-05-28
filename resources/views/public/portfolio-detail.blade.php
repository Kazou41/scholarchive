@extends('layouts.app')
@section('title', $portfolio->title . ' — Scholarchive')

@section('content')
<section class="pd-page">
    <div class="pd-arc"></div>
    <div class="container" style="max-width:900px;position:relative;z-index:1;">
        {{-- Breadcrumb --}}
        <div class="pd-breadcrumb">
            <a href="{{ route('portfolio.search') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Portofolio
            </a>
            <span class="pd-breadcrumb-sep">/</span>
            <span>{{ $portfolio->title }}</span>
        </div>

        {{-- Media --}}
        <div class="pd-media" id="pd-media-wrap">
            @if($portfolio->video_url)
                @php
                    $embedUrl = $portfolio->video_url;
                    if (str_contains($embedUrl, 'youtube.com') || str_contains($embedUrl, 'youtu.be')) {
                        $parsed = parse_url($embedUrl);
                        $videoId = null;
                        if (isset($parsed['host']) && str_contains($parsed['host'], 'youtu.be')) {
                            $videoId = ltrim($parsed['path'] ?? '', '/');
                        } elseif (isset($parsed['query'])) {
                            parse_str($parsed['query'], $query);
                            $videoId = $query['v'] ?? null;
                        }
                        if (!$videoId && isset($parsed['path']) && str_contains($parsed['path'], '/embed/')) {
                            $videoId = str_replace('/embed/', '', $parsed['path']);
                        }
                        if (!$videoId && isset($parsed['path']) && str_contains($parsed['path'], '/shorts/')) {
                            $videoId = str_replace('/shorts/', '', $parsed['path']);
                        }
                        if (!$videoId && isset($parsed['path']) && str_contains($parsed['path'], '/live/')) {
                            $videoId = str_replace('/live/', '', $parsed['path']);
                        }
                        if ($videoId) {
                            $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                        }
                    }
                @endphp
                <iframe src="{{ $embedUrl }}" style="width:100%; aspect-ratio: 16/9; border:none; border-radius:1rem; display:block;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                
                @if($portfolio->file_path && str_starts_with($portfolio->file_type, 'image/'))
                    <div style="margin-top:1rem;">
                        <img src="{{ asset('storage/' . $portfolio->file_path) }}" alt="{{ $portfolio->title }} Thumbnail" style="width:100%; border-radius:1rem; cursor:pointer;" data-preview="{{ asset('storage/' . $portfolio->file_path) }}" onclick="openPreview(this)">
                    </div>
                @endif
            @elseif($portfolio->file_type && str_starts_with($portfolio->file_type, 'image/'))
                <img src="{{ asset('storage/' . $portfolio->file_path) }}" alt="{{ $portfolio->title }}" class="pd-media-img" data-preview="{{ asset('storage/' . $portfolio->file_path) }}">
            @elseif($portfolio->file_type === 'application/pdf' && $portfolio->file_path)
                <iframe src="{{ asset('storage/' . $portfolio->file_path) }}" style="width:100%; height:800px; border:none; border-radius:1rem; display:block; background:#fff;"></iframe>
                <div style="margin-top:1rem;text-align:right;">
                    <a href="{{ asset('storage/' . $portfolio->file_path) }}" target="_blank" class="pd-btn-primary" style="display:inline-flex;padding:0.5rem 1rem;font-size:0.875rem;">Buka di Tab Baru / Unduh</a>
                </div>
            @elseif($portfolio->file_path)
                <div class="pd-media-file">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:48px;height:48px;color:#818cf8;margin-bottom:1rem;"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    <a href="{{ asset('storage/' . $portfolio->file_path) }}" target="_blank" class="pd-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        Unduh / Lihat File Asli
                    </a>
                </div>
            @else
                <img src="https://picsum.photos/seed/{{ $portfolio->id }}/900/450" alt="{{ $portfolio->title }}" class="pd-media-img" data-preview="https://picsum.photos/seed/{{ $portfolio->id }}/1200/800">
            @endif
        </div>

        {{-- Title & Meta --}}
        <div class="pd-header">
            <h1 class="pd-title">{{ $portfolio->title }}</h1>
            <div class="pd-tags">
                @foreach($portfolio->categories as $cat)
                    <span class="pd-tag pd-tag-primary">{{ $cat->name }}</span>
                @endforeach
                <span class="pd-tag pd-tag-info">{{ ucfirst($portfolio->type) }}</span>
                @if($portfolio->is_featured)
                    <span class="pd-tag pd-tag-success">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                        Unggulan
                    </span>
                @endif
            </div>
        </div>

        {{-- Author Row --}}
        <div class="pd-author">
            <a href="{{ route('student.public-profile', $portfolio->student->id) }}" class="pd-author-link">
                <div class="pd-avatar">{{ substr($portfolio->student->name, 0, 1) }}</div>
                <div>
                    <div class="pd-author-name">{{ $portfolio->student->name }}</div>
                    <div class="pd-author-meta">{{ $portfolio->student->studentProfile->class_name ?? '' }} · {{ $portfolio->student->studentProfile->major ?? '' }}</div>
                </div>
            </a>
            <div class="pd-stats">
                <span class="pd-stat-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ number_format($portfolio->view_count) }}
                </span>
                <span class="pd-stat-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    {{ $portfolio->created_at->format('d M Y') }}
                </span>
            </div>
        </div>

        {{-- Description --}}
        <div class="pd-card">
            <h3 class="pd-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                Deskripsi Karya
            </h3>
            <div class="pd-description">{{ $portfolio->description }}</div>
        </div>

        {{-- Assessment --}}
        @if($portfolio->assessments->isNotEmpty())
        <div class="pd-card pd-card-assess">
            <h3 class="pd-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342"/></svg>
                Penilaian Guru
            </h3>
            @foreach($portfolio->assessments as $assessment)
            <div class="pd-assess-item {{ !$loop->last ? 'pd-assess-border' : '' }}">
                <div class="pd-score-wrap">
                    <span class="pd-score">{{ $assessment->score }}</span>
                    <span class="pd-score-max">/ 100</span>
                </div>
                <p class="pd-feedback">{{ $assessment->feedback }}</p>
                <div class="pd-assess-meta">— {{ $assessment->admin->name }}, Admin · {{ $assessment->assessed_at->format('d M Y') }}</div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Navigation --}}
        <div class="pd-nav">
            <a href="{{ route('portfolio.search') }}" class="pd-btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali ke Portofolio
            </a>
            <a href="{{ route('student.public-profile', $portfolio->student->id) }}" class="pd-btn-outline">
                Lihat Profil Siswa
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- Lightbox --}}
<div class="sp-lightbox" id="sp-lightbox">
    <div class="sp-lightbox-backdrop"></div>
    <div class="sp-lightbox-content">
        <button class="sp-lightbox-close" id="sp-lightbox-close">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:24px;height:24px;"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <img id="sp-lightbox-img" src="" alt="Preview">
    </div>
</div>

<style>
/* ===== PORTFOLIO DETAIL DARK ===== */
.pd-page {
    background: linear-gradient(180deg, #0b0f1a 0%, #111827 40%, #0f172a 100%);
    min-height: 100vh;
    padding: 2rem 0 4rem;
    position: relative;
    overflow: hidden;
}
.pd-arc {
    position: absolute; top: -400px; left: 50%; transform: translateX(-50%);
    width: 1000px; height: 1000px; border-radius: 50%;
    border: 1px solid rgba(99, 102, 241, 0.08); pointer-events: none;
}

/* Breadcrumb */
.pd-breadcrumb {
    display: flex; align-items: center; gap: 0.5rem;
    font-size: 0.8125rem; color: #64748b; margin-bottom: 1.5rem;
}
.pd-breadcrumb a {
    display: inline-flex; align-items: center; gap: 0.375rem;
    color: #818cf8; text-decoration: none; font-weight: 500;
    transition: color 0.15s;
}
.pd-breadcrumb a:hover { color: #a5b4fc; }
.pd-breadcrumb-sep { color: #475569; }

/* Media */
.pd-media {
    border-radius: 1rem; overflow: hidden;
    margin-bottom: 1.75rem; background: rgba(15, 23, 42, 0.5);
    border: 1px solid rgba(148, 163, 184, 0.08);
}
.pd-media-img {
    width: 100%; display: block; cursor: pointer;
    transition: filter 0.3s ease;
}
.pd-media-img:hover { filter: brightness(0.85); }
.pd-media-file {
    padding: 4rem; text-align: center;
    background: rgba(30, 41, 59, 0.5);
}

/* Header */
.pd-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem;
}
.pd-title {
    font-size: 1.75rem; font-weight: 800; color: #f1f5f9; margin: 0;
}
.pd-tags { display: flex; gap: 0.375rem; flex-wrap: wrap; align-items: center; }
.pd-tag {
    display: inline-flex; align-items: center; gap: 0.25rem;
    padding: 0.25rem 0.75rem; border-radius: 999px;
    font-size: 0.6875rem; font-weight: 600;
}
.pd-tag-primary { background: rgba(99, 102, 241, 0.15); color: #818cf8; }
.pd-tag-info { background: rgba(59, 130, 246, 0.15); color: #60a5fa; }
.pd-tag-success { background: rgba(16, 185, 129, 0.15); color: #34d399; }

/* Author */
.pd-author {
    display: flex; align-items: center; justify-content: space-between;
    gap: 1rem; flex-wrap: wrap;
    padding: 1rem 0; margin-bottom: 1.5rem;
    border-bottom: 1px solid rgba(148, 163, 184, 0.08);
}
.pd-author-link {
    display: flex; align-items: center; gap: 0.75rem;
    text-decoration: none; transition: opacity 0.15s;
}
.pd-author-link:hover { opacity: 0.85; }
.pd-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    background: rgba(99, 102, 241, 0.15); color: #818cf8;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.875rem;
}
.pd-author-name { font-size: 0.9375rem; font-weight: 700; color: #f1f5f9; }
.pd-author-meta { font-size: 0.75rem; color: #94a3b8; }
.pd-stats { display: flex; gap: 1rem; }
.pd-stat-item {
    display: inline-flex; align-items: center; gap: 0.375rem;
    font-size: 0.8125rem; color: #94a3b8;
}
.pd-stat-item svg { width: 16px; height: 16px; color: #64748b; }

/* Card */
.pd-card {
    background: rgba(30, 41, 59, 0.4);
    border: 1px solid rgba(148, 163, 184, 0.08);
    border-radius: 1rem; padding: 1.5rem;
    margin-bottom: 1.25rem;
    backdrop-filter: blur(8px);
}
.pd-card-assess { border-left: 4px solid #34d399; }
.pd-card-title {
    display: flex; align-items: center; gap: 0.5rem;
    font-size: 1rem; font-weight: 700; color: #f1f5f9;
    margin-bottom: 0.75rem;
}
.pd-card-title svg { color: #818cf8; }
.pd-description {
    line-height: 1.8; white-space: pre-wrap; color: #cbd5e1; font-size: 0.9375rem;
}

/* Assessment */
.pd-assess-item { margin-bottom: 1.25rem; }
.pd-assess-border {
    border-bottom: 1px solid rgba(148, 163, 184, 0.08);
    padding-bottom: 1.25rem;
}
.pd-score-wrap { display: flex; align-items: baseline; gap: 0.375rem; margin-bottom: 0.5rem; }
.pd-score {
    font-family: 'Poppins', sans-serif; font-size: 2rem; font-weight: 800; color: #34d399;
}
.pd-score-max { font-size: 0.875rem; color: #64748b; }
.pd-feedback { line-height: 1.7; color: #cbd5e1; white-space: pre-wrap; font-size: 0.9375rem; }
.pd-assess-meta { font-size: 0.8125rem; color: #94a3b8; margin-top: 0.5rem; }

/* Navigation */
.pd-nav {
    display: flex; justify-content: space-between; margin-top: 2rem;
}
.pd-btn-primary, .pd-btn-secondary, .pd-btn-outline {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.75rem 1.25rem; border-radius: 0.625rem;
    font-weight: 600; font-size: 0.875rem; text-decoration: none;
    transition: all 0.2s; font-family: 'Poppins', sans-serif;
}
.pd-btn-primary {
    background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff;
}
.pd-btn-primary:hover { box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3); transform: translateY(-1px); }
.pd-btn-secondary {
    background: rgba(148, 163, 184, 0.08); color: #cbd5e1;
    border: 1px solid rgba(148, 163, 184, 0.12);
}
.pd-btn-secondary:hover { background: rgba(148, 163, 184, 0.15); color: #f1f5f9; }
.pd-btn-outline {
    background: transparent; color: #818cf8;
    border: 1px solid rgba(99, 102, 241, 0.2);
}
.pd-btn-outline:hover { background: rgba(99, 102, 241, 0.08); border-color: rgba(99, 102, 241, 0.4); }

/* Lightbox (reuse from student-profile) */
.sp-lightbox {
    position: fixed; inset: 0; z-index: 9999;
    display: flex; align-items: center; justify-content: center;
    opacity: 0; visibility: hidden;
    transition: opacity 0.35s ease, visibility 0.35s ease;
}
.sp-lightbox.active { opacity: 1; visibility: visible; }
.sp-lightbox-backdrop {
    position: absolute; inset: 0;
    background: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
}
.sp-lightbox-content {
    position: relative; max-width: 90vw; max-height: 90vh;
    display: flex; flex-direction: column; align-items: center;
    transform: scale(0.9) translateY(20px);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.sp-lightbox.active .sp-lightbox-content { transform: scale(1) translateY(0); }
.sp-lightbox-content img {
    max-width: 90vw; max-height: 88vh; object-fit: contain;
    border-radius: 0.75rem; box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
}
.sp-lightbox-close {
    position: absolute; top: -50px; right: 0;
    background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.15);
    color: #fff; border-radius: 50%;
    width: 40px; height: 40px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.2s;
}
.sp-lightbox-close:hover { background: rgba(255, 255, 255, 0.2); transform: rotate(90deg); }

@media (max-width: 768px) {
    .pd-header { flex-direction: column; }
    .pd-title { font-size: 1.375rem; }
    .pd-author { flex-direction: column; align-items: flex-start; }
    .pd-nav { flex-direction: column; gap: 0.75rem; }
    .pd-nav a { justify-content: center; }
    .pd-arc { width: 600px; height: 600px; top: -280px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var lightbox = document.getElementById('sp-lightbox');
    var lightboxImg = document.getElementById('sp-lightbox-img');
    var closeBtn = document.getElementById('sp-lightbox-close');
    var backdrop = lightbox.querySelector('.sp-lightbox-backdrop');

    // Open on image click
    document.querySelectorAll('.pd-media-img[data-preview]').forEach(function(el) {
        el.addEventListener('click', function() {
            lightboxImg.src = this.getAttribute('data-preview');
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

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
