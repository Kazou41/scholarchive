@extends('layouts.app')
@section('title', 'Edit Portofolio — Scholarchive')

@section('content')
<section class="section" style="padding-top:2rem;">
    <div class="container" style="max-width:700px;">
        <a href="{{ route('student.profile') }}" class="text-sm text-primary mb-2" style="display:inline-block;">← Kembali ke Profil</a>

        <div class="card">
            <h2 style="margin-bottom:1.5rem;">Edit Karya: {{ $portfolio->title }}</h2>
            <form action="{{ route('student.portfolio.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                @if($errors->any())
                    <div style="background:#fee2e2;color:#b91c1c;padding:0.75rem;border-radius:0.375rem;margin-bottom:1rem;font-size:0.875rem;">
                        <ul style="margin:0;padding-left:1.5rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label class="form-label">Nama Karya / Proyek *</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Nova Brand Identity" value="{{ old('title', $portfolio->title) }}" required>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Jenis Karya *</label>
                        <select name="type" class="form-control form-select" required>
                            <option value="">Pilih jenis karya</option>
                            <option value="poster" {{ old('type', $portfolio->type) == 'poster' ? 'selected' : '' }}>Poster</option>
                            <option value="video" {{ old('type', $portfolio->type) == 'video' ? 'selected' : '' }}>Video</option>
                            <option value="desain" {{ old('type', $portfolio->type) == 'desain' ? 'selected' : '' }}>Desain</option>
                            <option value="dokumen" {{ old('type', $portfolio->type) == 'dokumen' ? 'selected' : '' }}>Dokumen</option>
                            <option value="fotografi" {{ old('type', $portfolio->type) == 'fotografi' ? 'selected' : '' }}>Fotografi</option>
                            <option value="tugas praktik" {{ old('type', $portfolio->type) == 'tugas praktik' ? 'selected' : '' }}>Tugas Praktik</option>
                            <option value="presentasi" {{ old('type', $portfolio->type) == 'presentasi' ? 'selected' : '' }}>Presentasi</option>
                            <option value="prototype" {{ old('type', $portfolio->type) == 'prototype' ? 'selected' : '' }}>Prototype</option>
                            <option value="aplikasi" {{ old('type', $portfolio->type) == 'aplikasi' ? 'selected' : '' }}>Aplikasi / Software</option>
                            <option value="blueprint" {{ old('type', $portfolio->type) == 'blueprint' ? 'selected' : '' }}>Blueprint / Cetak Biru</option>
                            <option value="laporan" {{ old('type', $portfolio->type) == 'laporan' ? 'selected' : '' }}>Laporan Proyek</option>
                            <option value="animasi" {{ old('type', $portfolio->type) == 'animasi' ? 'selected' : '' }}>Animasi</option>
                            <option value="film" {{ old('type', $portfolio->type) == 'film' ? 'selected' : '' }}>Film / Broadcasting</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori *</label>
                        <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                            @php
                                $currentCategories = old('categories', $portfolio->categories->pluck('id')->toArray());
                            @endphp
                            @foreach($categories as $cat)
                            <label style="display:flex;align-items:center;gap:0.25rem;font-size:0.8125rem;cursor:pointer;padding:0.375rem 0.75rem;border:1.5px solid var(--border-subtle);border-radius:var(--radius-full);">
                                <input type="checkbox" name="categories[]" value="{{ $cat->id }}" style="accent-color:var(--primary);" {{ (is_array($currentCategories) && in_array($cat->id, $currentCategories)) ? 'checked' : '' }}> {{ $cat->name }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi Karya *</label>
                    <textarea name="description" class="form-control" rows="5" placeholder="Jelaskan tentang karya Anda, proses pembuatan, tools yang digunakan, dll..." required>{{ old('description', $portfolio->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Upload File Baru (Opsional)</label>
                    <div style="border:2px dashed var(--border-subtle);border-radius:var(--radius-lg);padding:2rem;text-align:center;cursor:pointer;transition:var(--transition);" onclick="document.getElementById('file-upload').click()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:36px;height:36px;color:var(--outline);margin:0 auto 0.5rem;display:block;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/></svg>
                        <p class="text-sm font-semibold" style="color:var(--text-heading);">Klik untuk mengunggah file baru menggantikan yang lama</p>
                        <p class="text-xs text-muted">Biarkan kosong untuk mempertahankan file saat ini ({{ basename($portfolio->file_path) }})</p>
                        <input type="file" name="file" id="file-upload" style="display:none;" onchange="document.getElementById('file-preview').textContent = this.files[0] ? this.files[0].name : ''">
                    </div>
                    <div id="file-preview" class="mt-1 text-sm font-semibold" style="color:var(--primary);"></div>
                </div>
                <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
                    <button type="submit" class="btn btn-primary">Perbarui Karya</button>
                    <a href="{{ route('student.profile') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
