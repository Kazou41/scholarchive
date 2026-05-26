@extends('layouts.admin')
@section('title', 'Detail Siswa')
@section('page-title', 'Detail Siswa — ' . $user->name)

@section('content')
<a href="{{ route('admin.students.index') }}" class="text-sm text-primary mb-2" style="display:inline-block;">← Kembali ke Daftar Siswa</a>

@if(session('success'))
    <div style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);color:#34d399;padding:0.75rem 1rem;border-radius:0.5rem;margin-bottom:1rem;font-size:0.875rem;">
        {{ session('success') }}
    </div>
@endif

<div class="grid-2" style="grid-template-columns:1fr 2fr;gap:1.5rem;">
    {{-- Profile Card --}}
    <div class="card" style="text-align:center;">
        <div class="avatar avatar-xl" style="margin:0 auto 1rem;background:var(--primary);color:#fff;overflow:hidden;">
            @if($user->studentProfile && $user->studentProfile->photo)
                <img src="{{ asset('storage/' . $user->studentProfile->photo) }}" alt="Foto Profil" style="width:100%;height:100%;object-fit:cover;">
            @else
                <span>{{ substr($user->name, 0, 2) }}</span>
            @endif
        </div>
        <h2>{{ $user->name }}</h2>
        <p class="text-sm text-muted">{{ $user->studentProfile->class_name ?? 'Kelas' }} · {{ $user->studentProfile->major ?? 'Jurusan' }}</p>
        <p class="text-sm mt-1" style="line-height:1.6;">{{ $user->studentProfile->bio ?? '' }}</p>
        <div style="display:flex;gap:0.5rem;flex-wrap:wrap;justify-content:center;margin:1rem 0;">
            @foreach($user->skills as $skill)
            <span class="badge badge-primary">{{ $skill->name }}</span>
            @endforeach
        </div>
        <div class="text-xs text-muted" style="display:inline-flex; align-items:center; gap:0.375rem; justify-content:center; width:100%; margin-top:0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:14px;height:14px;opacity:0.8;"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
            <span>{{ $user->email }}</span>
        </div>
        <div style="display:flex;gap:1rem;justify-content:center;margin-top:1.25rem;">
            <div style="text-align:center;">
                <div class="font-bold" style="font-size:1.25rem;color:var(--text-heading);">{{ $user->portfolios->count() }}</div>
                <div class="text-xs text-muted">Karya</div>
            </div>
            <div style="text-align:center;">
                @php
                    $assessedWorks = $user->portfolios->filter(fn($p) => $p->latestAssessment);
                    $avgScore = $assessedWorks->count() > 0 ? $assessedWorks->avg(fn($p) => $p->latestAssessment->score) : 0;
                @endphp
                <div class="font-bold" style="font-size:1.25rem;color:var(--status-success);">{{ number_format($avgScore, 1) }}</div>
                <div class="text-xs text-muted">Rata-rata Nilai</div>
            </div>
            <div style="text-align:center;">
                <div class="font-bold" style="font-size:1.25rem;color:var(--primary);">{{ $assessedWorks->count() }}</div>
                <div class="text-xs text-muted">Sudah Dinilai</div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div style="display:flex;flex-direction:column;gap:0.5rem;margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid rgba(148,163,184,0.1);">
            <a href="{{ route('admin.students.edit', $user->id) }}" class="btn btn-outline" style="justify-content:center; width:100%; display:inline-flex; align-items:center; gap:0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                <span>Edit Profil</span>
            </a>
            <form action="{{ route('admin.students.destroy', $user->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('⚠️ Apakah Anda yakin ingin menghapus akun {{ $user->name }}?\n\nSemua data termasuk karya, keahlian, dan profil akan dihapus secara permanen.\n\nTindakan ini TIDAK DAPAT dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="justify-content:center; width:100%; display:inline-flex; align-items:center; gap:0.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                    <span>Hapus Akun</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Works List --}}
    <div>
        <h3 class="mb-2">Riwayat Portofolio</h3>
        @forelse($user->portfolios as $work)
        <div class="card card-flat mb-1" style="padding:1rem;">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div>
                        <div class="font-semibold text-sm" style="color:var(--text-heading);">
                            <a href="{{ route('admin.works.show', $work->id) }}" style="text-decoration:none;color:inherit;">{{ $work->title }}</a>
                        </div>
                        <div class="text-xs text-muted" style="display:flex; align-items:center; gap:0.375rem; margin-top:0.25rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:12px;height:12px;opacity:0.7;"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/></svg>
                            <span>{{ $work->created_at->format('d M Y') }}</span>
                            <span>·</span>
                            <span class="badge badge-primary" style="font-size:0.625rem; padding: 0.125rem 0.375rem;">{{ $work->categories->pluck('name')->join(', ') }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    @if($work->latestAssessment)
                    <span class="badge badge-success">Nilai: {{ $work->latestAssessment->score }}</span>
                    @else
                    <span class="badge badge-warning">Menunggu Penilaian</span>
                    @endif
                </div>
            </div>
        </div>
        @empty
            <p class="text-sm text-muted">Belum ada karya yang diunggah.</p>
        @endforelse
    </div>
</div>
@endsection
