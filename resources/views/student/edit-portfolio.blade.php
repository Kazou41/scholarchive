@extends('layouts.app')
@section('title', 'Edit Portofolio — Scholarchive')

@section('content')
<section class="dk-page">
    <div class="dk-arc"></div>
    <div class="container" style="max-width:700px;position:relative;z-index:1;">
        <a href="{{ route('student.profile') }}" class="dk-back-link animate-item delay-1">← Kembali ke Profil</a>

        <div class="dk-card animate-item delay-2">
            <h2 class="dk-card-title">Edit Karya: {{ $portfolio->title }}</h2>
            <form action="{{ route('student.portfolio.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                @if($errors->any())
                    <div class="dk-alert-error">
                        <ul style="margin:0;padding-left:1.5rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="dk-form-group">
                    <label class="dk-label">Nama Karya / Proyek *</label>
                    <input type="text" name="title" class="dk-input" placeholder="e.g. Nova Brand Identity" value="{{ old('title', $portfolio->title) }}" required>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div class="dk-form-group">
                        <label class="dk-label">Jenis Karya *</label>
                        <select name="type" class="dk-input dk-select" required>
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
                    <div class="dk-form-group">
                        <label class="dk-label">Kategori *</label>
                        <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                            @php
                                $currentCategories = old('categories', $portfolio->categories->pluck('id')->toArray());
                            @endphp
                            @foreach($categories as $cat)
                            <div class="dk-chip-wrap">
                                <input type="checkbox" id="cat_{{ $cat->id }}" name="categories[]" value="{{ $cat->id }}" class="dk-chip-input" {{ (is_array($currentCategories) && in_array($cat->id, $currentCategories)) ? 'checked' : '' }}>
                                <label for="cat_{{ $cat->id }}" class="dk-chip-label">{{ $cat->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="dk-form-group">
                    <label class="dk-label">Deskripsi Karya *</label>
                    <textarea name="description" class="dk-input dk-textarea" rows="5" placeholder="Jelaskan tentang karya Anda, proses pembuatan, tools yang digunakan, dll..." required>{{ old('description', $portfolio->description) }}</textarea>
                </div>
                <div class="dk-form-group">
                    <label class="dk-label">Upload File Baru (Opsional)</label>
                    <div class="dk-upload-zone" onclick="document.getElementById('file-upload').click()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:36px;height:36px;color:#818cf8;margin:0 auto 0.5rem;display:block;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/></svg>
                        <p style="font-weight:600;color:#e2e8f0;font-size:0.875rem;">Klik untuk mengunggah file baru menggantikan yang lama</p>
                        <p style="font-size:0.75rem;color:#64748b;">Biarkan kosong untuk mempertahankan file ({{ basename($portfolio->file_path) }})</p>
                        <input type="file" name="file" id="file-upload" style="display:none;" onchange="document.getElementById('file-preview').textContent = this.files[0] ? this.files[0].name : ''">
                    </div>
                    <div id="file-preview" style="margin-top:0.5rem;font-size:0.875rem;font-weight:600;color:#818cf8;"></div>
                </div>
                <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
                    <button type="submit" class="dk-btn-primary">Perbarui Karya</button>
                    <a href="{{ route('student.profile') }}" class="dk-btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
/* ===== SHARED DARK PAGE ===== */
.dk-page {
    background: linear-gradient(180deg, #0b0f1a 0%, #111827 40%, #0f172a 100%);
    min-height: 100vh;
    padding: 2rem 0 4rem;
    position: relative;
    overflow: hidden;
}
.dk-arc {
    position: absolute;
    top: -350px;
    left: 50%;
    transform: translateX(-50%);
    width: 900px;
    height: 900px;
    border-radius: 50%;
    border: 1px solid rgba(99, 102, 241, 0.1);
    pointer-events: none;
}
.dk-arc::before {
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
.dk-back-link {
    display: inline-block;
    font-size: 0.875rem;
    color: #818cf8;
    margin-bottom: 1rem;
    text-decoration: none;
    transition: color 0.15s;
}
.dk-back-link:hover { color: #a5b4fc; }

.dk-card {
    background: rgba(30, 41, 59, 0.5);
    border: 1px solid rgba(148, 163, 184, 0.08);
    border-radius: 1rem;
    padding: 2rem;
    backdrop-filter: blur(12px);
}
.dk-card-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #f1f5f9;
    margin-bottom: 1.5rem;
}
.dk-form-group {
    margin-bottom: 1rem;
}
.dk-label {
    display: block;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #cbd5e1;
    margin-bottom: 0.375rem;
}
.dk-input {
    width: 100%;
    background: rgba(15, 23, 42, 0.6);
    border: 1.5px solid rgba(148, 163, 184, 0.12);
    border-radius: 0.625rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    color: #e2e8f0;
    font-family: 'Poppins', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.dk-input::placeholder { color: rgba(148, 163, 184, 0.45); }
.dk-input:focus {
    outline: none;
    border-color: rgba(99, 102, 241, 0.5);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    background: rgba(15, 23, 42, 0.8);
}
.dk-select {
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 14px;
    padding-right: 2rem;
    cursor: pointer;
}
.dk-select option { background: #1e293b; color: #e2e8f0; }
.dk-textarea { resize: vertical; min-height: 120px; }
/* Chip Checkboxes */
.dk-chip-wrap { display: inline-block; }
.dk-chip-input { display: none; }
.dk-chip-label {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8125rem;
    font-weight: 500;
    cursor: pointer;
    padding: 0.5rem 1rem;
    border: 1px solid rgba(148, 163, 184, 0.15);
    background: rgba(30, 41, 59, 0.4);
    border-radius: 999px;
    color: #94a3b8;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    user-select: none;
}
.dk-chip-label:hover {
    border-color: rgba(99, 102, 241, 0.3);
    color: #cbd5e1;
    background: rgba(30, 41, 59, 0.7);
}
.dk-chip-input:checked + .dk-chip-label {
    background: rgba(99, 102, 241, 0.15);
    border-color: #818cf8;
    color: #ffffff;
    box-shadow: 0 0 12px rgba(99, 102, 241, 0.2);
}

.dk-upload-zone {
    border: 2px dashed rgba(99, 102, 241, 0.2);
    border-radius: 1rem;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: rgba(15, 23, 42, 0.3);
}
.dk-upload-zone:hover {
    border-color: rgba(99, 102, 241, 0.4);
    background: rgba(15, 23, 42, 0.5);
}

.dk-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff;
    padding: 0.75rem 1.5rem;
    border-radius: 0.625rem;
    font-weight: 600;
    font-size: 0.875rem;
    border: none;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    transition: all 0.2s;
    text-decoration: none;
}
.dk-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
}
.dk-btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(148, 163, 184, 0.08);
    color: #cbd5e1;
    padding: 0.75rem 1.5rem;
    border-radius: 0.625rem;
    font-weight: 600;
    font-size: 0.875rem;
    border: 1px solid rgba(148, 163, 184, 0.12);
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    transition: all 0.2s;
    text-decoration: none;
}
.dk-btn-secondary:hover { background: rgba(148, 163, 184, 0.15); color: #e2e8f0; }

.dk-alert-error {
    background: rgba(185, 28, 28, 0.15);
    color: #fca5a5;
    padding: 0.75rem;
    border-radius: 0.625rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
    border: 1px solid rgba(185, 28, 28, 0.2);
}

@media (max-width: 768px) {
    .dk-page { padding: 1.5rem 0 3rem; }
    .dk-card { padding: 1.5rem; }
    .dk-arc { width: 600px; height: 600px; top: -250px; }
}
</style>
@endsection
