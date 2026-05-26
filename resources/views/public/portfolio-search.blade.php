@extends('layouts.app')
@section('title', 'Jelajahi Portofolio — Scholarchive')

@section('content')
<section class="pf-page">
    {{-- Decorative arcs (flipped 180° from hero) --}}
    <div class="pf-arc"></div>

    <div class="container" style="position:relative;z-index:1;">
        {{-- Header --}}
        <div class="pf-header animate-item delay-1">
            <h1 class="pf-title">Jelajahi Portofolio</h1>
            <p class="pf-subtitle">Temukan karya terbaik dari siswa-siswi berbakat</p>
        </div>

        {{-- Filter Bar --}}
        <form class="pf-filter-bar animate-item delay-2" method="GET" action="{{ route('portfolio.search') }}">
            <input type="hidden" name="tab" id="search-tab-input" value="{{ $tab }}">
            <div class="pf-search-box">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;color:rgba(148,163,184,0.5);flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $tab === 'siswa' ? 'Cari nama siswa, jurusan, keahlian...' : 'Cari judul karya, deskripsi...' }}">
            </div>
            @if($tab === 'karya')
            <select name="category" class="pf-select" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="type" class="pf-select" onchange="this.form.submit()">
                <option value="">Semua Jenis</option>
                @foreach($types as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
            @endif
            <button type="submit" style="display:none;"></button>
        </form>

        {{-- Switch Tab Bar --}}
        <div class="pf-switch-container animate-item delay-3">
            <div class="pf-switch" data-active="{{ $tab }}">
                <div class="pf-switch-glare"></div>
                <button type="button" class="pf-switch-btn {{ $tab === 'siswa' ? 'active' : '' }}" onclick="switchTab('siswa')">Siswa</button>
                <button type="button" class="pf-switch-btn {{ $tab === 'karya' ? 'active' : '' }}" onclick="switchTab('karya')">Karya</button>
            </div>
        </div>

        @if($tab === 'siswa')
        {{-- Student Grid --}}
        <div class="student-grid animate-item delay-4">
            @forelse($students as $student)
            <a href="{{ route('student.public-profile', $student->id) }}" class="student-card" style="text-decoration:none;color:inherit;">
                {{-- Banner/Cover --}}
                @if($student->studentProfile && $student->studentProfile->banner)
                <div class="student-card-banner">
                    <img src="{{ asset('storage/' . $student->studentProfile->banner) }}" alt="Banner">
                </div>
                @else
                <div class="student-card-banner default-banner"></div>
                @endif

                {{-- Photo Avatar --}}
                <div class="student-card-avatar-wrap">
                    <div class="student-card-avatar">
                        @if($student->studentProfile && $student->studentProfile->photo)
                            <img src="{{ asset('storage/' . $student->studentProfile->photo) }}" alt="{{ $student->name }}">
                        @else
                            <span>{{ substr($student->name, 0, 1) }}</span>
                        @endif
                    </div>
                </div>

                <div class="student-card-body">
                    <h3 class="student-card-name">{{ $student->name }}</h3>
                    <p class="student-card-major">
                        {{ $student->studentProfile?->class_name ?? 'Kelas' }} · {{ $student->studentProfile?->major ?? 'Rekayasa Perangkat Lunak' }}
                    </p>
                    <div class="student-card-skills">
                        @forelse($student->skills->take(3) as $skill)
                            <span class="student-skill-tag">{{ $skill->name }}</span>
                        @empty
                            <span class="student-skill-tag-empty">Belum ada keahlian</span>
                        @endforelse
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; color: #64748b; padding: 3rem;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:48px;height:48px;color:#475569;margin-bottom:1rem;"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                <p style="font-size:1rem;font-weight:500;color:#94a3b8;">Tidak ada siswa yang ditemukan</p>
                <p style="font-size:0.875rem;color:#64748b;">Coba ubah kata kunci pencarian Anda.</p>
            </div>
            @endforelse
        </div>
        @else
        {{-- Portfolio Grid --}}
        <div class="portfolio-grid animate-item delay-4">
            @forelse($portfolios as $work)
            <a href="{{ route('portfolio.detail', $work->slug) }}" class="portfolio-card" style="text-decoration:none;color:inherit;">
                <div class="portfolio-card-img"><img src="{{ $work->file_path ? asset('storage/' . $work->file_path) : 'https://picsum.photos/seed/'.$work->id.'/600/400' }}" alt="{{ $work->title }}"></div>
                <div class="portfolio-card-body">
                    <div class="portfolio-card-cats">
                        @foreach($work->categories->take(1) as $cat)
                            <span class="badge badge-primary">{{ $cat->name }}</span>
                        @endforeach
                        <span class="badge badge-info">{{ ucfirst($work->type) }}</span>
                    </div>
                    <h3 class="portfolio-card-title mt-1">{{ $work->title }}</h3>
                    <div class="portfolio-card-meta">
                        <div class="avatar avatar-sm"><span>{{ substr($work->student->name ?? 'A', 0, 1) }}</span></div>
                        <span>{{ $work->student->name ?? 'Tidak diketahui' }}</span>
                        <span style="margin-left:auto;">👁 {{ number_format($work->view_count) }}</span>
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; color: #64748b; padding: 3rem;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:48px;height:48px;color:#475569;margin-bottom:1rem;"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                <p style="font-size:1rem;font-weight:500;color:#94a3b8;">Tidak ada karya yang ditemukan</p>
                <p style="font-size:0.875rem;color:#64748b;">Coba ubah kata kunci atau filter pencarian Anda.</p>
            </div>
            @endforelse
        </div>
        @endif

        {{-- Pagination --}}
        <div style="margin-top:2rem;">
            @if($tab === 'siswa')
                {{ $students->links() }}
            @else
                {{ $portfolios->links() }}
            @endif
        </div>
    </div>
</section>

<style>
/* ===== PORTFOLIO PAGE DARK THEME ===== */
.pf-page {
    background: linear-gradient(180deg, #0b0f1a 0%, #111827 40%, #0f172a 100%);
    min-height: 100vh;
    padding: 2rem 0 4rem;
    position: relative;
    overflow: hidden;
}

/* Decorative arcs - flipped 180° (at top instead of bottom) */
.pf-arc {
    position: absolute;
    top: -350px;
    left: 50%;
    transform: translateX(-50%) rotate(180deg);
    width: 900px;
    height: 900px;
    border-radius: 50%;
    border: 1px solid rgba(99, 102, 241, 0.12);
    pointer-events: none;
}
.pf-arc::before {
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
.pf-arc::after {
    content: '';
    position: absolute;
    bottom: -40px;
    left: 50%;
    transform: translateX(-50%);
    width: 500px;
    height: 500px;
    border-radius: 50%;
    border: 1px solid rgba(99, 102, 241, 0.04);
}

/* Header */
.pf-header {
    text-align: center;
    margin-bottom: 2.5rem;
    padding-top: 1rem;
}
.pf-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #f1f5f9;
    margin-bottom: 0.5rem;
}
.pf-subtitle {
    color: #94a3b8;
    font-size: 1rem;
}

/* Filter Bar */
.pf-filter-bar {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}
.pf-search-box {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    background: rgba(30, 41, 59, 0.4);
    border: 1px solid rgba(148, 163, 184, 0.15);
    border-radius: 999px;
    flex: 1;
    min-width: 240px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(8px);
}
.pf-search-box:hover {
    border-color: rgba(99, 102, 241, 0.3);
    background: rgba(30, 41, 59, 0.6);
}
.pf-search-box:focus-within {
    border-color: #818cf8;
    background: rgba(30, 41, 59, 0.8);
    box-shadow: 0 0 15px rgba(99, 102, 241, 0.15);
}
.pf-search-box input {
    border: none;
    background: transparent;
    outline: none;
    font-size: 0.875rem;
    font-family: 'Poppins', sans-serif;
    color: #f1f5f9;
    width: 100%;
}
.pf-search-box input::placeholder { color: #64748b; font-weight: 500; }

.pf-select {
    padding: 0.625rem 2.5rem 0.625rem 1.25rem;
    background: rgba(30, 41, 59, 0.4);
    border: 1px solid rgba(148, 163, 184, 0.15);
    border-radius: 999px;
    color: #cbd5e1;
    font-size: 0.875rem;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    cursor: pointer;
    outline: none;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23818cf8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 14px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(8px);
}
.pf-select:hover {
    border-color: rgba(99, 102, 241, 0.3);
    background: rgba(30, 41, 59, 0.6);
    color: #f1f5f9;
}
.pf-select:focus {
    border-color: #818cf8;
    background: rgba(30, 41, 59, 0.8);
    box-shadow: 0 0 15px rgba(99, 102, 241, 0.15);
    color: #ffffff;
}
.pf-select option {
    background: #1e293b;
    color: #e2e8f0;
    font-weight: 500;
}

/* Portfolio cards in dark context */
.pf-page .portfolio-card {
    background: rgba(30, 41, 59, 0.5);
    border: 1px solid rgba(148, 163, 184, 0.08);
    border-radius: 1rem;
    transition: all 0.25s ease;
}
.pf-page .portfolio-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    border-color: rgba(99, 102, 241, 0.2);
}
.pf-page .portfolio-card-title { color: #f1f5f9; }
.pf-page .portfolio-card-meta { color: #64748b; }
.pf-page .portfolio-card-meta span { color: #94a3b8; }
.pf-page .portfolio-card-img { background: rgba(15, 23, 42, 0.5); }
.pf-page .avatar { background: rgba(99, 102, 241, 0.15); color: #818cf8; }
.pf-page .badge-primary { background: rgba(99, 102, 241, 0.15); color: #818cf8; }
.pf-page .badge-info { background: rgba(59, 130, 246, 0.15); color: #60a5fa; }

/* Pagination dark */
.pf-page nav[role="navigation"] span,
.pf-page nav[role="navigation"] a {
    background: rgba(30, 41, 59, 0.5);
    border-color: rgba(148, 163, 184, 0.1);
    color: #94a3b8;
}
.pf-page nav[role="navigation"] a:hover {
    background: rgba(99, 102, 241, 0.1);
    border-color: rgba(99, 102, 241, 0.3);
    color: #818cf8;
}
.pf-page nav[role="navigation"] span[aria-current="page"] span {
    background: #6366f1;
    border-color: #6366f1;
    color: #fff;
}

@media (max-width: 768px) {
    .pf-title { font-size: 1.75rem; }
    .pf-filter-bar { flex-direction: column; }
    .pf-search-box { min-width: 100%; }
    .pf-select { width: 100%; }
    .pf-arc { width: 600px; height: 600px; top: -250px; }
}

/* ===== SWITCH TAB BAR ===== */
.pf-switch-container {
    display: flex;
    justify-content: center;
    margin-top: -0.5rem;
    margin-bottom: 2rem;
}
.pf-switch {
    position: relative;
    display: flex;
    background: rgba(15, 23, 42, 0.5);
    border: 1px solid rgba(148, 163, 184, 0.1);
    border-radius: 999px;
    padding: 4px;
    width: 240px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}
.pf-switch-btn {
    flex: 1;
    background: none;
    border: none;
    outline: none;
    padding: 0.625rem 0;
    font-size: 0.875rem;
    font-weight: 600;
    color: #94a3b8;
    cursor: pointer;
    z-index: 2;
    transition: color 0.3s;
    font-family: 'Poppins', sans-serif;
    text-align: center;
}
.pf-switch-btn.active {
    color: #fff;
}
.pf-switch-glare {
    position: absolute;
    top: 4px;
    bottom: 4px;
    left: 4px;
    width: calc(50% - 4px);
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    border-radius: 999px;
    z-index: 1;
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}
.pf-switch[data-active="karya"] .pf-switch-glare {
    transform: translateX(100%);
    background: linear-gradient(135deg, #6366f1, #818cf8);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

/* ===== STUDENT GRID & CARD ===== */
.student-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}
.student-card {
    background: rgba(30, 41, 59, 0.5);
    border: 1px solid rgba(148, 163, 184, 0.08);
    border-radius: 1rem;
    overflow: hidden;
    backdrop-filter: blur(16px);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    flex-direction: column;
    height: 100%;
}
.student-card:hover {
    transform: translateY(-6px);
    border-color: rgba(99, 102, 241, 0.25);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(99, 102, 241, 0.1);
    background: rgba(30, 41, 59, 0.65);
}
.student-card-banner {
    height: 90px;
    width: 100%;
    overflow: hidden;
    background: linear-gradient(135deg, #1e293b, #0f172a);
}
.student-card-banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.student-card-banner.default-banner {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    opacity: 0.8;
}
.student-card-avatar-wrap {
    display: flex;
    justify-content: center;
    margin-top: -45px;
    margin-bottom: 0.5rem;
}
.student-card-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: rgba(99, 102, 241, 0.2);
    border: 3px solid #0f172a;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #818cf8;
    font-size: 1.75rem;
    font-weight: 700;
}
.student-card-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.student-card-body {
    padding: 0 1.25rem 1.5rem;
    text-align: center;
}
.student-card-name {
    font-size: 1.05rem;
    font-weight: 700;
    color: #f1f5f9;
    margin-bottom: 0.25rem;
    transition: color 0.2s;
}
.student-card:hover .student-card-name {
    color: #818cf8;
}
.student-card-major {
    font-size: 0.75rem;
    color: #94a3b8;
    margin-bottom: 0.75rem;
    font-weight: 500;
}
.student-card-skills {
    display: flex;
    gap: 0.375rem;
    flex-wrap: wrap;
    justify-content: center;
}
.student-skill-tag {
    font-size: 0.6875rem;
    font-weight: 600;
    color: #818cf8;
    background: rgba(99, 102, 241, 0.12);
    padding: 0.15rem 0.5rem;
    border-radius: 999px;
    border: 1px solid rgba(99, 102, 241, 0.1);
}
.student-skill-tag-empty {
    font-size: 0.6875rem;
    color: #64748b;
    font-style: italic;
}
</style>

<script>
function switchTab(tab) {
    document.getElementById('search-tab-input').value = tab;
    // Clear filters if switching to Siswa to avoid query string mismatch
    if (tab === 'siswa') {
        const catSelect = document.querySelector('select[name="category"]');
        const typeSelect = document.querySelector('select[name="type"]');
        if (catSelect) catSelect.value = '';
        if (typeSelect) typeSelect.value = '';
    }
    document.querySelector('.pf-filter-bar').submit();
}
</script>
@endsection
