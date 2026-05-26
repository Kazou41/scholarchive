@extends('layouts.admin')
@section('title', 'Ringkasan Dashboard')
@section('page-title', 'Ringkasan Dashboard')

@section('content')
{{-- Stat Cards --}}
<div class="stat-grid">
    <div class="stat-card">
        <div>
            <div class="stat-card-label">Total Siswa</div>
            <div class="stat-card-value">{{ number_format($stats['total_students']) }}</div>
        </div>
        <div class="stat-card-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:22px;height:22px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
        </div>
    </div>
    <div class="stat-card">
        <div>
            <div class="stat-card-label">Total Karya</div>
            <div class="stat-card-value">{{ number_format($stats['total_works']) }}</div>
        </div>
        <div class="stat-card-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:22px;height:22px"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
        </div>
    </div>
    <div class="stat-card">
        <div>
            <div class="stat-card-label">Karya Dinilai</div>
            <div class="stat-card-value">{{ number_format($stats['assessed_works']) }}</div>
            @php $pct = $stats['total_works'] > 0 ? round(($stats['assessed_works'] / $stats['total_works']) * 100) : 0; @endphp
            <div class="text-xs text-muted mt-1">{{ $pct }}% selesai</div>
            <div class="progress mt-1" style="width:120px;"><div class="progress-bar blue" style="width:{{ $pct }}%;"></div></div>
        </div>
        <div class="stat-card-icon" style="color:var(--status-success);">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:22px;height:22px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
    </div>
    <div class="stat-card">
        <div>
            <div class="stat-card-label">Pesan Masuk</div>
            <div class="stat-card-value">{{ number_format($stats['total_messages']) }}</div>
            @if($stats['new_messages'] > 0)
                <div class="stat-card-trend" style="color:var(--status-warning);">{{ $stats['new_messages'] }} Baru</div>
            @else
                <div class="stat-card-trend up">Semua Terbaca</div>
            @endif
        </div>
        <div class="stat-card-icon" style="color:var(--status-warning);">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:22px;height:22px"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
        </div>
    </div>
</div>

{{-- Content Grid --}}
<div class="grid-2" style="grid-template-columns:1.5fr 1fr;">
    {{-- Recent Submissions --}}
    <div class="card">
        <div class="flex items-center justify-between mb-2">
            <h3>Karya Terbaru</h3>
            <a href="{{ route('admin.works.index') }}" class="text-sm font-semibold" style="color:#818cf8;">Lihat Semua</a>
        </div>
        @forelse($recentWorks as $work)
        <div class="flex items-center gap-2" style="padding:0.875rem 0;border-bottom:1px solid rgba(148,163,184,0.08);">
            <div class="avatar"><span>{{ substr($work->student->name ?? 'A',0,1) }}</span></div>
            <div style="flex:1;">
                <div class="font-semibold text-sm" style="color:#f1f5f9;">
                    <a href="{{ route('admin.works.show', $work->id) }}" style="text-decoration:none;color:#f1f5f9;">{{ $work->title }}</a>
                </div>
                <div class="text-xs" style="color:#94a3b8;">Diunggah oleh {{ $work->student->name ?? 'Tidak diketahui' }}</div>
            </div>
            <div style="text-align:right;">
                @if($work->categories->isNotEmpty())
                <span class="badge badge-primary">{{ $work->categories->first()->name }}</span>
                @endif
                <div class="text-xs" style="color:#94a3b8;">{{ $work->created_at->diffForHumans() }}</div>
            </div>
        </div>
        @empty
        <p class="text-sm text-muted text-center py-4">Belum ada karya yang diunggah.</p>
        @endforelse
    </div>

    {{-- Right Column --}}
    <div style="display:flex;flex-direction:column;gap:1rem;">
        {{-- Quick Actions --}}
        <div class="card" style="padding:0;">
            <div style="padding:1.25rem 1.25rem 0.75rem;"><h3>Aksi Cepat</h3></div>
            <a href="{{ route('admin.students.create') }}" class="quick-action" style="text-decoration:none;">
                <div class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;color:#818cf8;"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
                    <span style="font-size:0.875rem;font-weight:600;color:#e2e8f0;">Tambah Siswa Baru</span>
                </div>
                <span style="color:#94a3b8;">›</span>
            </a>
            <a href="{{ route('admin.feedback.index') }}" class="quick-action" style="text-decoration:none;">
                <div class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;color:#a78bfa;"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    <span style="font-size:0.875rem;font-weight:600;color:#e2e8f0;">Lihat Pesan ({{ $stats['new_messages'] }})</span>
                </div>
                <span style="color:#94a3b8;">›</span>
            </a>
            <a href="{{ route('admin.works.index', ['status' => 'pending']) }}" class="quick-action" style="text-decoration:none;">
                <div class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;color:#fbbf24;"><path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75"/></svg>
                    @php $pendingWorks = $stats['total_works'] - $stats['assessed_works']; @endphp
                    <span style="font-size:0.875rem;font-weight:600;color:#e2e8f0;">Tinjau Pending ({{ $pendingWorks }})</span>
                </div>
                <span style="color:#94a3b8;">›</span>
            </a>
        </div>

        {{-- Department Breakdown --}}
        <div class="card">
            <h3 style="margin-bottom:1rem;">Sebaran Jurusan</h3>
            @php
                $colors = ['blue', 'purple', 'green', 'orange', 'red', 'teal'];
            @endphp
            @forelse($departmentBreakdown as $index => $dept)
            <div style="margin-bottom:0.875rem;">
                <div class="flex items-center justify-between text-sm mb-1">
                    <span style="font-weight:600;color:#f1f5f9;">{{ $dept['name'] }}</span>
                    <span style="color:#cbd5e1;">{{ $dept['count'] }} siswa ({{ $dept['pct'] }}%)</span>
                </div>
                <div class="progress"><div class="progress-bar {{ $colors[$index % count($colors)] }}" style="width:{{ $dept['pct'] }}%;"></div></div>
            </div>
            @empty
            <p class="text-sm text-muted">Belum ada data jurusan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
