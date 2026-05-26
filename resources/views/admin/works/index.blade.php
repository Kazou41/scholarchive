@extends('layouts.admin')
@section('title', 'Manajemen Karya')
@section('page-title', 'Manajemen Karya')

@section('content')
<form class="filter-bar" method="GET" action="{{ route('admin.works.index') }}">
    <div class="search-input">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berdasarkan judul karya atau nama siswa...">
    </div>
    <select name="status" class="form-control form-select" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        <option value="assessed" {{ request('status') == 'assessed' ? 'selected' : '' }}>Sudah Dinilai</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Penilaian</option>
    </select>
    <button type="submit" style="display:none;"></button>
</form>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Judul Karya</th>
                <th>Nama Siswa</th>
                <th>Kategori</th>
                <th>Tanggal Unggah</th>
                <th>Nilai</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($works as $work)
            <tr>
                <td>
                    <div class="flex items-center gap-1">
                        <div style="width:40px;height:40px;border-radius:var(--radius);overflow:hidden;background:var(--surface-container);flex-shrink:0;">
                            <img src="{{ $work->file_path ? asset('storage/' . $work->file_path) : 'https://picsum.photos/seed/'.$work->id.'/80/80' }}" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                        <a href="{{ route('admin.works.show', $work->id) }}" class="font-semibold text-sm text-primary">{{ $work->title }}</a>
                    </div>
                </td>
                <td class="text-sm">{{ $work->student->name ?? 'Tidak diketahui' }}</td>
                <td>
                    @if($work->categories->isNotEmpty())
                    <span class="badge badge-primary">{{ $work->categories->first()->name }}</span>
                    @endif
                </td>
                <td class="text-sm">{{ $work->created_at->format('d M Y') }}</td>
                <td class="font-bold">{{ $work->latestAssessment->score ?? '—' }}</td>
                <td>
                    <div style="display:flex; flex-direction:column; gap:0.375rem; align-items:flex-start;">
                        @if($work->latestAssessment)
                            <span class="badge badge-success" style="display:inline-flex; align-items:center; gap:0.25rem; font-size:0.75rem; padding:0.25rem 0.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                <span>Sudah Dinilai</span>
                            </span>
                        @else
                            <span class="badge badge-warning" style="display:inline-flex; align-items:center; gap:0.25rem; font-size:0.75rem; padding:0.25rem 0.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>Menunggu Penilaian</span>
                            </span>
                        @endif
                        @if($work->is_featured)
                            <span class="badge badge-info" style="display:inline-flex; align-items:center; gap:0.25rem; font-size:0.75rem; padding:0.25rem 0.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.151-.316.633-.316.785 0l2.36 4.817 5.317.773c.348.05.487.48.236.726l-3.848 3.75 1.026 5.295c.067.348-.299.613-.607.45l-4.757-2.502-4.757 2.502c-.307.163-.674-.102-.607-.45l1.026-5.295-3.848-3.75c-.25-.246-.112-.676.236-.726l5.317-.773 2.36-4.817z" /></svg>
                                <span>Unggulan</span>
                            </span>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="dropdown" style="position:relative;">
                        <button class="btn btn-icon btn-ghost" data-dropdown>⋮</button>
                        <div class="dropdown-menu" style="position:absolute;right:0;top:100%;background:var(--surface-container);border-radius:var(--radius-md);box-shadow:0 4px 12px rgba(0,0,0,0.15);z-index:10;display:none;min-width:170px;padding:0.375rem;border: 1px solid rgba(148, 163, 184, 0.1);">
                            <a href="{{ route('admin.works.show', $work->id) }}" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Lihat Detail</span>
                            </a>
                            <form action="{{ route('admin.works.featured', $work->id) }}" method="POST" style="margin:0;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="dropdown-item {{ $work->is_featured ? 'danger' : 'info' }}">
                                    @if($work->is_featured)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                        <span>Hapus Unggulan</span>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.151-.316.633-.316.785 0l2.36 4.817 5.317.773c.348.05.487.48.236.726l-3.848 3.75 1.026 5.295c.067.348-.299.613-.607.45l-4.757-2.502-4.757 2.502c-.307.163-.674-.102-.607-.45l1.026-5.295-3.848-3.75c-.25-.246-.112-.676.236-.726l5.317-.773 2.36-4.817z"/></svg>
                                        <span>Unggulkan</span>
                                    @endif
                                </button>
                            </form>
                            <form action="{{ route('admin.works.destroy', $work->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karya ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    <span>Hapus Karya</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">Belum ada karya yang ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="table-footer" style="padding:1rem;">
        {{ $works->links() }}
    </div>
    <style>
        .dropdown-menu.show { display: block !important; }
        .dropdown-item {
            display: flex !important;
            align-items: center;
            gap: 0.625rem;
            width: 100%;
            padding: 0.5rem 0.75rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: var(--radius-sm);
            font-size: 0.8125rem;
            font-weight: 500;
            transition: all 0.2s ease;
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
            box-sizing: border-box;
        }
        .dropdown-item svg {
            color: var(--text-muted);
            transition: color 0.2s ease;
            flex-shrink: 0;
        }
        .dropdown-item:hover {
            background: rgba(99, 102, 241, 0.08);
            color: #818cf8 !important;
        }
        .dropdown-item:hover svg {
            color: #818cf8 !important;
        }
        .dropdown-item.info:hover {
            background: rgba(56, 189, 248, 0.08);
            color: #38bdf8 !important;
        }
        .dropdown-item.info:hover svg {
            color: #38bdf8 !important;
        }
        .dropdown-item.danger:hover {
            background: rgba(239, 68, 68, 0.08);
            color: #fca5a5 !important;
        }
        .dropdown-item.danger:hover svg {
            color: #fca5a5 !important;
        }
    </style>
</div>
@endsection
