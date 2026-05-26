@extends('layouts.admin')
@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Saya')

@section('content')
<div class="stat-grid" style="grid-template-columns:repeat(3,1fr);">
    <div class="stat-card">
        <div>
            <div class="stat-card-label">Karya Saya</div>
            <div class="stat-card-value">6</div>
        </div>
        <div class="stat-card-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:22px;height:22px"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg></div>
    </div>
    <div class="stat-card">
        <div>
            <div class="stat-card-label">Rata-rata Nilai</div>
            <div class="stat-card-value">89.2</div>
        </div>
        <div class="stat-card-icon" style="background:rgba(16,185,129,0.1);color:#34d399;"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:22px;height:22px"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg></div>
    </div>
    <div class="stat-card">
        <div>
            <div class="stat-card-label">Kunjungan Profil</div>
            <div class="stat-card-value">342</div>
        </div>
        <div class="stat-card-icon" style="background:rgba(139,92,246,0.1);color:#a78bfa;"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:22px;height:22px"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
    </div>
</div>

<div style="display:flex;gap:0.75rem;margin-bottom:1.5rem;">
    <a href="{{ route('student.portfolio.create') }}" class="btn btn-primary">+ Unggah Karya</a>
    <a href="{{ route('student.generate-cv') }}" class="btn btn-secondary" style="border:1px solid rgba(148,163,184,0.15);">✨ Buat CV</a>
    <a href="{{ route('student.profile') }}" class="btn btn-secondary" style="border:1px solid rgba(148,163,184,0.15);">Edit Profil</a>
</div>

<h3 style="color:#f1f5f9;margin-bottom:1rem;font-size:1.125rem;">Karya Saya</h3>
<div class="portfolio-grid">
    @foreach([
        ['title'=>'Nova Brand Identity','cat'=>'Design','img'=>'https://picsum.photos/seed/my1/600/400','score'=>92,'status'=>'Diterbitkan'],
        ['title'=>'Mobile Banking App Redesign','cat'=>'Design','img'=>'https://picsum.photos/seed/my2/600/400','score'=>88,'status'=>'Diterbitkan'],
        ['title'=>'Event Branding Kit','cat'=>'Design','img'=>'https://picsum.photos/seed/my3/600/400','score'=>null,'status'=>'Menunggu'],
    ] as $work)
    <div class="portfolio-card">
        <div class="portfolio-card-img"><img src="{{ $work['img'] }}" alt="{{ $work['title'] }}"></div>
        <div class="portfolio-card-body">
            <div class="portfolio-card-cats">
                <span class="badge badge-primary">{{ $work['cat'] }}</span>
                @if($work['score'])<span class="badge badge-success">Nilai: {{ $work['score'] }}</span>@else<span class="badge badge-warning">{{ $work['status'] }}</span>@endif
            </div>
            <h3 class="portfolio-card-title mt-1">{{ $work['title'] }}</h3>
        </div>
    </div>
    @endforeach
</div>
@endsection
