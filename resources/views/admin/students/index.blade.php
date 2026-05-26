@extends('layouts.admin')
@section('title', 'Daftar Siswa')
@section('page-title', 'Daftar Siswa')

@section('content')
<form class="filter-bar" method="GET" action="{{ route('admin.students.index') }}">
    <div class="search-input" style="flex:1;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berdasarkan nama atau email...">
    </div>
    <button type="submit" class="btn btn-icon btn-secondary" style="margin-right:auto;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
    </button>
    <div>
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary">+ Tambah Siswa</a>
    </div>
</form>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Karya</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr>
                <td>
                    <div class="flex items-center gap-1">
                        <div class="avatar"><span>{{ substr($student->name, 0, 2) }}</span></div>
                        <div>
                            <div class="font-semibold" style="color:var(--text-heading);">{{ $student->name }}</div>
                            <div class="text-xs text-muted">{{ $student->email }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $student->studentProfile->class_name ?? '—' }}</td>
                <td>{{ $student->studentProfile->major ?? '—' }}</td>
                <td><strong>{{ $student->portfolios->count() }}</strong></td>
                <td>
                    @if($student->is_active)
                    <span class="badge badge-success">● Aktif</span>
                    @else
                    <span class="badge badge-danger">● Nonaktif</span>
                    @endif
                </td>
                <td>
                    <div class="dropdown" style="position:relative;">
                        <button class="btn btn-icon btn-ghost" data-dropdown>⋮</button>
                        <div class="dropdown-menu" style="position:absolute;right:0;top:100%;background:var(--surface-container);border-radius:var(--radius-md);box-shadow:0 4px 12px rgba(0,0,0,0.15);z-index:10;display:none;min-width:170px;padding:0.375rem;border: 1px solid rgba(148, 163, 184, 0.1);">
                            <a href="{{ route('admin.students.show', $student->id) }}" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                <span>Lihat Profil</span>
                            </a>
                            <a href="{{ route('admin.students.edit', $student->id) }}" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                <span>Edit Profil</span>
                            </a>
                            <form action="{{ route('admin.students.toggle', $student->id) }}" method="POST" style="margin:0;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="dropdown-item {{ $student->is_active ? 'danger' : 'success' }}">
                                    @if($student->is_active)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                        <span>Nonaktifkan</span>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>Aktifkan Akun</span>
                                    @endif
                                </button>
                            </form>
                            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('⚠️ Yakin hapus akun {{ $student->name }}? Semua data akan hilang permanen.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    <span>Hapus Akun</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-4">Belum ada data siswa yang ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="table-footer" style="padding:1rem;">
        {{ $students->links() }}
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
        .dropdown-item.success:hover {
            background: rgba(16, 185, 129, 0.08);
            color: #34d399 !important;
        }
        .dropdown-item.success:hover svg {
            color: #34d399 !important;
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
