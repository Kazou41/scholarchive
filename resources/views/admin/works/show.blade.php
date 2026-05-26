@extends('layouts.admin')
@section('title', 'Detail Karya')
@section('page-title', 'Detail Karya — ' . $portfolio->title)

@section('content')
<a href="{{ route('admin.works.index') }}" class="text-sm text-primary mb-2" style="display:inline-block;">← Kembali ke Daftar Karya</a>

<div class="grid-2" style="grid-template-columns:1.5fr 1fr;gap:1.5rem;">
    <div>
        <div style="border-radius:var(--radius-lg);overflow:hidden;margin-bottom:1.5rem;background:var(--surface-container);">
            @if($portfolio->file_type && str_starts_with($portfolio->file_type, 'image/'))
                <img src="{{ asset('storage/' . $portfolio->file_path) }}" alt="{{ $portfolio->title }}" style="width:100%;display:block;">
            @elseif($portfolio->file_path)
                <div style="padding: 4rem; text-align: center; background: var(--surface-card);">
                    <a href="{{ asset('storage/' . $portfolio->file_path) }}" target="_blank" class="btn btn-primary">Unduh/Lihat File Asli</a>
                </div>
            @else
                <img src="https://picsum.photos/seed/{{ $portfolio->id }}/700/400" style="width:100%;display:block;">
            @endif
        </div>
        <div class="card">
            <h2 style="margin-bottom:0.5rem;">{{ $portfolio->title }}</h2>
            <div class="flex gap-1 mb-2">
                @foreach($portfolio->categories as $cat)
                <span class="badge badge-primary">{{ $cat->name }}</span>
                @endforeach
                <span class="badge badge-info">{{ ucfirst($portfolio->type) }}</span>
            </div>
            <div style="line-height:1.7;white-space:pre-wrap;">{{ $portfolio->description }}</div>
            <div class="text-sm text-muted mt-2" style="display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap;">
                <span style="display:inline-flex; align-items:center; gap:0.25rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;opacity:0.8;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>{{ number_format($portfolio->view_count) }} dilihat</span>
                </span>
                <span>·</span>
                <span style="display:inline-flex; align-items:center; gap:0.25rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;opacity:0.8;"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/></svg>
                    <span>{{ $portfolio->created_at->format('d M Y') }}</span>
                </span>
            </div>
        </div>
    </div>
    <div>
        <div class="card mb-2">
            <h3 style="margin-bottom:0.75rem;">Info Siswa</h3>
            <div class="flex items-center gap-1">
                <div class="avatar"><span>{{ substr($portfolio->student->name ?? 'A', 0, 2) }}</span></div>
                <div><div class="font-semibold text-sm">{{ $portfolio->student->name ?? 'Tidak diketahui' }}</div><div class="text-xs text-muted">{{ $portfolio->student->studentProfile->class_name ?? '' }} · {{ $portfolio->student->studentProfile->major ?? '' }}</div></div>
            </div>
        </div>
        <div class="card">
            <h3 style="margin-bottom:1rem;">Penilaian</h3>
            @if(session('success'))
                <div style="background:#dcfce7;color:#166534;padding:0.75rem;border-radius:0.375rem;margin-bottom:1rem;font-size:0.875rem;">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div style="background:#fee2e2;color:#b91c1c;padding:0.75rem;border-radius:0.375rem;margin-bottom:1rem;font-size:0.875rem;">
                    <ul style="margin:0;padding-left:1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.works.assess', $portfolio->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nilai (0-100)</label>
                    <input type="number" name="score" class="form-control" value="{{ old('score', $portfolio->latestAssessment->score ?? '') }}" min="0" max="100" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Komentar / Umpan Balik</label>
                    <textarea name="feedback" class="form-control" rows="4">{{ old('feedback', $portfolio->latestAssessment->feedback ?? '') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary w-full" style="justify-content:center;">Simpan Penilaian</button>
            </form>

            <form action="{{ route('admin.works.featured', $portfolio->id) }}" method="POST" style="margin-top:1rem;">
                @csrf
                @method('PATCH')
                <div class="form-group" style="margin-bottom:0;">
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                        <input type="checkbox" onchange="this.form.submit()" {{ $portfolio->is_featured ? 'checked' : '' }}> Jadikan sebagai Unggulan
                    </label>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
