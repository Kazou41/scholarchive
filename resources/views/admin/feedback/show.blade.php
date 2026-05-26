@extends('layouts.admin')
@section('title', 'Detail Pesan')
@section('page-title', 'Detail Pesan')

@section('content')
<a href="{{ route('admin.feedback.index') }}" class="text-sm text-primary mb-2" style="display:inline-block;">← Kembali ke Daftar Pesan</a>

<div class="card" style="max-width:640px;">
    <div class="flex items-center gap-2 mb-2">
        <div class="avatar avatar-lg"><span>{{ substr($message->name, 0, 2) }}</span></div>
        <div>
            <h2 style="margin:0;">{{ $message->name }}</h2>
            <p class="text-sm text-muted">{{ $message->email }} · {{ $message->created_at->format('d M Y H:i') }}</p>
        </div>
        @php
            $statusLabel = match($message->status) {
                'new' => 'Baru',
                'read' => 'Dibaca',
                'resolved' => 'Selesai',
                default => ucfirst($message->status),
            };
        @endphp
        <span class="badge {{ $message->status === 'new' ? 'badge-primary' : ($message->status === 'read' ? 'badge-warning' : 'badge-success') }}" style="margin-left:auto;">{{ $statusLabel }}</span>
    </div>

    <div style="background:var(--surface-container-low);border-radius:var(--radius);padding:1.25rem;margin-bottom:1.5rem;">
        <p style="line-height:1.7;white-space:pre-wrap;">{{ $message->message }}</p>
    </div>

    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:0.75rem;border-radius:0.375rem;margin-bottom:1rem;font-size:0.875rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display:flex;gap:0.75rem;">
        @if($message->status !== 'resolved')
        <form action="{{ route('admin.feedback.resolve', $message->id) }}" method="POST" style="margin:0;">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-primary">✓ Tandai Selesai</button>
        </form>
        @endif
    </div>
</div>
@endsection
