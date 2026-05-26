@extends('layouts.admin')
@section('title', 'Manajemen Pesan')
@section('page-title', 'Manajemen Pesan')

@section('content')
<div style="margin-bottom:1.5rem;">
    <h2>Manajemen Pesan</h2>
    <p class="text-sm text-muted">Tinjau dan tanggapi pesan dari siswa dan pengguna umum.</p>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Pesan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $msg)
            <tr>
                <td>
                    <div class="flex items-center gap-1">
                        <div class="avatar"><span>{{ substr($msg->name, 0, 2) }}</span></div>
                        <span class="font-semibold text-sm" style="color:var(--text-heading);">{{ $msg->name }}</span>
                    </div>
                </td>
                <td class="text-sm">{{ $msg->email }}</td>
                <td class="text-sm" style="max-width:250px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $msg->message }}</td>
                <td class="text-sm">{{ $msg->created_at->format('d M Y') }}</td>
                <td>
                    @if($msg->status === 'new')
                        <span class="badge badge-primary">Baru</span>
                    @elseif($msg->status === 'read')
                        <span class="badge badge-warning">Dibaca</span>
                    @else
                        <span class="badge badge-success">Selesai</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.feedback.show', $msg->id) }}" class="btn btn-sm btn-ghost">Lihat</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-4">Belum ada pesan masuk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="table-footer" style="padding:1rem;">
        {{ $messages->links() }}
    </div>
</div>
@endsection
