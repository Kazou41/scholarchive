@extends('layouts.app')
@section('title', 'Edit Profil — Scholarchive')

@section('content')
<section class="dk-page">
    <div class="dk-arc"></div>
    
    <div class="container" style="max-width:800px;position:relative;z-index:1;">
        <a href="{{ route('student.profile') }}" class="dk-back-link">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Kembali ke Profil
        </a>

        @if(session('success'))
            <div class="dk-alert dk-alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="dk-alert dk-alert-danger">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <ul style="margin:0;padding-left:1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Edit Profile Info --}}
        <div class="dk-card" style="margin-bottom:2rem;">
            <div class="dk-card-header">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:24px;height:24px;color:#818cf8;"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                <h3 class="dk-card-title">Edit Informasi Profil</h3>
            </div>
            
            <form id="profile-edit-form" action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Banner Upload --}}
                <div class="dk-form-group" style="margin-bottom:1.5rem;">
                    <label class="dk-label">Foto Banner / Sampul</label>
                    <div style="position:relative;height:160px;border-radius:1rem;overflow:hidden;cursor:pointer;border:2px dashed rgba(148,163,184,0.3);transition:all 0.2s;" onclick="document.getElementById('banner-upload').click()" id="banner-wrapper">
                        <img src="" id="banner-new-preview" style="display:none;width:100%;height:100%;object-fit:cover;position:absolute;inset:0;z-index:2;">
                        <div id="banner-new-label" style="display:none;position:absolute;inset:0;background:rgba(0,0,0,0.5);z-index:3;align-items:center;justify-content:center;backdrop-filter:blur(4px);">
                            <span style="color:#fff;font-size:0.875rem;font-weight:600;display:flex;align-items:center;gap:0.5rem;"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:20px;height:20px;color:#34d399;"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg> Banner baru dipilih</span>
                        </div>

                        @if($user->studentProfile && $user->studentProfile->banner)
                            <img src="{{ asset('storage/' . $user->studentProfile->banner) }}" alt="Banner" style="width:100%;height:100%;object-fit:cover;">
                            <div style="position:absolute;inset:0;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity 0.2s;backdrop-filter:blur(4px);" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0">
                                <span style="color:#fff;font-size:0.875rem;font-weight:600;display:flex;align-items:center;gap:0.5rem;"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:20px;height:20px;"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/></svg> Ganti Banner</span>
                            </div>
                        @else
                            <div id="banner-placeholder" style="height:100%;background:linear-gradient(135deg, #1e293b 0%, #0f172a 100%);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:0.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:32px;height:32px;color:#818cf8;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                                <span style="color:#e2e8f0;font-size:0.8125rem;font-weight:600;">Klik untuk unggah foto banner</span>
                                <span style="color:#64748b;font-size:0.75rem;">Disarankan 1200 × 300px (maks. 4MB)</span>
                            </div>
                        @endif
                    </div>
                    <input type="file" name="banner" id="banner-upload" style="display:none;" accept="image/jpeg,image/png,image/jpg" onchange="previewBanner(this)">
                </div>

                {{-- Photo Upload --}}
                <div class="dk-form-group" style="text-align:center;margin-bottom:2rem;">
                    <div style="width:110px;height:110px;margin:0 auto 1rem;border-radius:50%;background:rgba(99,102,241,0.2);color:#818cf8;overflow:hidden;cursor:pointer;font-size:2rem;font-weight:700;display:flex;align-items:center;justify-content:center;border:4px solid rgba(15,23,42,0.9);box-shadow:0 4px 15px rgba(0,0,0,0.3);" onclick="document.getElementById('photo-upload').click()">
                        @if($user->studentProfile && $user->studentProfile->photo)
                            <img src="{{ asset('storage/' . $user->studentProfile->photo) }}" alt="Foto Profil" style="width:100%;height:100%;object-fit:cover;" id="photo-preview-img">
                        @else
                            <span id="photo-preview-initials">{{ substr($user->name, 0, 2) }}</span>
                        @endif
                    </div>
                    <label class="dk-chip" style="display:inline-flex;cursor:pointer;background:rgba(30,41,59,0.8);border-color:rgba(148,163,184,0.2);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/></svg>
                        Ganti Foto Profil
                        <input type="file" name="photo" id="photo-upload" style="display:none;" accept="image/jpeg,image/png,image/jpg" onchange="this.parentElement.style.borderColor='#818cf8'; this.parentElement.style.color='#818cf8';">
                    </label>
                </div>

                <div class="dk-grid-2">
                    <div class="dk-form-group">
                        <label class="dk-label">Nama Lengkap</label>
                        <input type="text" name="name" class="dk-input" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="dk-form-group">
                        <label class="dk-label">Email</label>
                        <input type="email" class="dk-input" value="{{ $user->email }}" disabled style="opacity:0.6;cursor:not-allowed;">
                    </div>
                </div>
                <div class="dk-grid-2">
                    <div class="dk-form-group">
                        <label class="dk-label">Telepon</label>
                        <input type="text" name="phone" class="dk-input" value="{{ old('phone', $user->studentProfile?->phone) }}" placeholder="contoh: 0812xxxxxxxx">
                    </div>
                    <div class="dk-form-group">
                        <label class="dk-label">Alamat</label>
                        <input type="text" name="address" class="dk-input" value="{{ old('address', $user->studentProfile?->address) }}" placeholder="contoh: Yogyakarta">
                    </div>
                </div>
                <div class="dk-grid-2">
                    <div class="dk-form-group">
                        <label class="dk-label">Kelas</label>
                        <select name="class_name" class="dk-input dk-select">
                            <option value="">— Pilih Kelas —</option>
                            @foreach(['X', 'XI', 'XII'] as $kelas)
                                <option value="{{ $kelas }}" {{ old('class_name', $user->studentProfile?->class_name) === $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="dk-form-group">
                        <label class="dk-label">Program Keahlian / Jurusan</label>
                        <select name="major" class="dk-input dk-select">
                            <option value="">— Pilih Jurusan —</option>
                            @php
                                $jurusanList = [
                                    'Broadcasting & Perfilman',
                                    'Teknik Jaringan Komputer & Telekomunikasi',
                                    'Desain Pemodelan & Informasi Bangunan',
                                    'Teknik Konstruksi & Perumahan',
                                    'Teknik Elektronika',
                                    'Teknik Ketenagalistrikan',
                                    'Teknik Otomotif',
                                    'Teknik Mesin',
                                ];
                            @endphp
                            @foreach($jurusanList as $jurusan)
                                <option value="{{ $jurusan }}" {{ old('major', $user->studentProfile?->major) === $jurusan ? 'selected' : '' }}>{{ $jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="dk-form-group" style="margin-bottom:1.5rem;">
                    <label class="dk-label">Bio</label>
                    <textarea name="bio" class="dk-input dk-textarea" rows="4" placeholder="Ceritakan tentang dirimu...">{{ old('bio', $user->studentProfile?->bio) }}</textarea>
                </div>
            </form>
        </div>

        {{-- Skills Section --}}
        <div class="dk-card" id="skills-section" style="margin-bottom:2rem;">
            <div class="dk-card-header">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:24px;height:24px;color:#34d399;"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09l2.846.813-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.428-1.428L13.5 18.75l1.183-.394a2.25 2.25 0 001.428-1.428l.394-1.183.394 1.183a2.25 2.25 0 001.428 1.428l1.183.394-1.183.394a2.25 2.25 0 00-1.428 1.428z"/></svg>
                <h3 class="dk-card-title">Kelola Keahlian</h3>
            </div>

            <form action="{{ route('student.skills.store') }}" method="POST" class="dk-grid-2" style="align-items:flex-end;margin-bottom:1.5rem;">
                @csrf
                <div class="dk-form-group" style="margin-bottom:0;">
                    <label class="dk-label">Nama Keahlian</label>
                    <input type="text" name="name" class="dk-input" placeholder="contoh: Figma" required>
                </div>
                <div style="display:flex;gap:0.75rem;align-items:flex-end;">
                    <div class="dk-form-group" style="margin-bottom:0;flex:1;">
                        <label class="dk-label">Level</label>
                        <select name="level" class="dk-input dk-select" required>
                            <option value="Beginner">Pemula</option>
                            <option value="Intermediate">Menengah</option>
                            <option value="Advanced">Mahir</option>
                        </select>
                    </div>
                    <button type="submit" class="dk-btn-primary" style="padding:0.75rem 1.25rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    </button>
                </div>
            </form>

            <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
                @forelse($user->skills as $skill)
                <div class="dk-skill-tag">
                    <span class="dk-skill-name">{{ $skill->name }}</span>
                    <span class="dk-skill-level">{{ $skill->level }}</span>
                    <form action="{{ route('student.skills.destroy', $skill->id) }}" method="POST" style="margin:0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dk-skill-delete" title="Hapus">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </form>
                </div>
                @empty
                <p style="color:#64748b;font-size:0.875rem;">Belum ada keahlian yang ditambahkan.</p>
                @endforelse
            </div>
        </div>

        {{-- Works Management --}}
        <div class="dk-card">
            <div class="dk-card-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:24px;height:24px;color:#f59e0b;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/></svg>
                    <h3 class="dk-card-title" style="margin:0;">Kelola Karya</h3>
                </div>
                <a href="{{ route('student.portfolio.create') }}" class="dk-btn-primary" style="padding:0.5rem 1rem;font-size:0.8125rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Unggah Baru
                </a>
            </div>

            <div class="dk-table-wrap">
                <table class="dk-table">
                    <thead>
                        <tr>
                            <th>Karya</th>
                            <th>Kategori</th>
                            <th>Status Penilaian</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->portfolios as $work)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:0.75rem;">
                                    @if(str_starts_with($work->file_type, 'image/'))
                                        <img src="{{ asset('storage/'.$work->file_path) }}" alt="" style="width:40px;height:40px;border-radius:0.5rem;object-fit:cover;border:1px solid rgba(148,163,184,0.1);">
                                    @else
                                        <div style="width:40px;height:40px;border-radius:0.5rem;background:rgba(99,102,241,0.15);display:flex;align-items:center;justify-content:center;color:#818cf8;">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div style="font-weight:600;color:#f1f5f9;font-size:0.875rem;">{{ $work->title }}</div>
                                        <div style="font-size:0.75rem;color:#94a3b8;">{{ ucfirst($work->type) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="display:flex;gap:0.375rem;flex-wrap:wrap;">
                                    @foreach($work->categories->take(2) as $cat)
                                        <span class="dk-badge dk-badge-primary">{{ $cat->name }}</span>
                                    @endforeach
                                    @if($work->categories->count() > 2)
                                        <span class="dk-badge dk-badge-secondary">+{{ $work->categories->count() - 2 }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($work->latestAssessment)
                                    <span class="dk-badge dk-badge-success">Dinilai ({{ $work->latestAssessment->score }})</span>
                                @else
                                    <span class="dk-badge dk-badge-warning">Menunggu</span>
                                @endif
                            </td>
                            <td style="text-align:right;">
                                <div style="display:inline-flex;gap:0.375rem;">
                                    <a href="{{ route('portfolio.detail', $work->slug) }}" class="dk-btn-icon" title="Lihat">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </a>
                                    <a href="{{ route('student.portfolio.edit', $work->id) }}" class="dk-btn-icon" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                                    </a>
                                    <form action="{{ route('student.portfolio.destroy', $work->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karya ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dk-btn-icon dk-text-danger" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align:center;padding:2rem;color:#64748b;">Belum ada karya yang diunggah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-top:2rem;">
            <a href="{{ route('student.profile') }}" class="dk-btn-secondary">Batal</a>
            <button type="submit" form="profile-edit-form" class="dk-btn-primary">
                Simpan Perubahan
            </button>
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
    position: absolute; top: -350px; left: 50%; transform: translateX(-50%);
    width: 900px; height: 900px; border-radius: 50%; border: 1px solid rgba(99, 102, 241, 0.1); pointer-events: none;
}
.dk-arc::before { content: ''; position: absolute; bottom: -20px; left: 50%; transform: translateX(-50%); width: 400px; height: 2px; background: rgba(99, 102, 241, 0.3); filter: blur(8px); }

/* Links & Alerts */
.dk-back-link { display: inline-flex; align-items: center; gap: 0.375rem; font-size: 0.875rem; font-weight: 500; color: #818cf8; margin-bottom: 1rem; text-decoration: none; transition: color 0.15s; }
.dk-back-link:hover { color: #a5b4fc; }
.dk-alert { padding: 1rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem; font-weight: 500; backdrop-filter: blur(8px); }
.dk-alert svg { width: 20px; height: 20px; flex-shrink: 0; }
.dk-alert-success { background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; }
.dk-alert-danger { background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171; align-items: flex-start; }

/* Card */
.dk-card { background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(148, 163, 184, 0.08); border-radius: 1rem; padding: 2rem; backdrop-filter: blur(12px); }
.dk-card-header { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; }
.dk-card-title { font-size: 1.25rem; font-weight: 700; color: #f1f5f9; margin: 0; }

/* Forms */
.dk-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.dk-form-group { margin-bottom: 1rem; }
.dk-label { display: block; font-size: 0.8125rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.375rem; }
.dk-input { width: 100%; background: rgba(15, 23, 42, 0.6); border: 1.5px solid rgba(148, 163, 184, 0.12); border-radius: 0.625rem; padding: 0.75rem 1rem; font-size: 0.875rem; color: #e2e8f0; font-family: 'Poppins', sans-serif; transition: border-color 0.2s, box-shadow 0.2s; }
.dk-input::placeholder { color: rgba(148, 163, 184, 0.45); }
.dk-input:focus { outline: none; border-color: rgba(99, 102, 241, 0.5); box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1); background: rgba(15, 23, 42, 0.8); }
.dk-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 14px; padding-right: 2rem; cursor: pointer; }
.dk-select option { background: #1e293b; color: #e2e8f0; }
.dk-textarea { resize: vertical; min-height: 100px; }

/* Buttons */
.dk-btn-primary { display: inline-flex; align-items: center; justify-content: center; gap: 0.375rem; padding: 0.75rem 1.5rem; border-radius: 0.625rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; font-size: 0.875rem; font-weight: 600; cursor: pointer; border: none; outline: none; transition: all 0.2s; text-decoration: none; }
.dk-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3); }
.dk-btn-secondary { display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem 1.5rem; border-radius: 0.625rem; background: rgba(148, 163, 184, 0.1); color: #cbd5e1; font-size: 0.875rem; font-weight: 600; cursor: pointer; border: 1px solid rgba(148, 163, 184, 0.2); transition: all 0.2s; text-decoration: none; }
.dk-btn-secondary:hover { background: rgba(148, 163, 184, 0.2); color: #f1f5f9; }
.dk-btn-icon { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 0.5rem; background: rgba(148, 163, 184, 0.1); color: #cbd5e1; border: none; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.dk-btn-icon svg { width: 16px; height: 16px; }
.dk-btn-icon:hover { background: rgba(99, 102, 241, 0.2); color: #818cf8; }
.dk-text-danger:hover { background: rgba(239, 68, 68, 0.15) !important; color: #f87171 !important; }
.dk-chip { display: flex; align-items: center; gap: 0.375rem; font-size: 0.8125rem; cursor: pointer; padding: 0.375rem 0.75rem; border: 1px solid rgba(148, 163, 184, 0.15); border-radius: 999px; color: #cbd5e1; transition: all 0.15s; }
.dk-chip:hover { border-color: rgba(99, 102, 241, 0.3); background: rgba(30, 41, 59, 1) !important; color: #e2e8f0; }

/* Skills Tags */
.dk-skill-tag { display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.375rem 0.75rem; background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(148, 163, 184, 0.1); border-radius: 999px; }
.dk-skill-name { font-size: 0.8125rem; font-weight: 600; color: #e2e8f0; }
.dk-skill-level { font-size: 0.6875rem; font-weight: 600; color: #34d399; background: rgba(16, 185, 129, 0.1); padding: 0.125rem 0.375rem; border-radius: 999px; }
.dk-skill-delete { background: none; border: none; color: #64748b; cursor: pointer; display: flex; align-items: center; padding: 0.125rem; border-radius: 50%; transition: all 0.2s; }
.dk-skill-delete svg { width: 14px; height: 14px; }
.dk-skill-delete:hover { background: rgba(239, 68, 68, 0.15); color: #f87171; }

/* Table */
.dk-table-wrap { overflow-x: auto; margin-top: 1rem; border-radius: 0.75rem; border: 1px solid rgba(148, 163, 184, 0.1); }
.dk-table { width: 100%; border-collapse: collapse; min-width: 600px; text-align: left; }
.dk-table th { background: rgba(15, 23, 42, 0.6); padding: 1rem; font-size: 0.75rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid rgba(148, 163, 184, 0.1); }
.dk-table td { padding: 1rem; border-bottom: 1px solid rgba(148, 163, 184, 0.05); color: #cbd5e1; font-size: 0.875rem; vertical-align: middle; }
.dk-table tr:last-child td { border-bottom: none; }
.dk-table tr:hover td { background: rgba(255, 255, 255, 0.02); }

/* Badges */
.dk-badge { display: inline-flex; align-items: center; padding: 0.2rem 0.5rem; border-radius: 0.375rem; font-size: 0.6875rem; font-weight: 600; }
.dk-badge-primary { background: rgba(99, 102, 241, 0.15); color: #818cf8; }
.dk-badge-success { background: rgba(16, 185, 129, 0.15); color: #34d399; }
.dk-badge-warning { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
.dk-badge-secondary { background: rgba(148, 163, 184, 0.15); color: #94a3b8; }

@media (max-width: 768px) {
    .dk-grid-2 { grid-template-columns: 1fr; gap: 0; }
    .dk-card { padding: 1.5rem; }
    .dk-table th, .dk-table td { padding: 0.75rem; }
}
</style>

<script>
function previewBanner(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var previewImg = document.getElementById('banner-new-preview');
            var previewLabel = document.getElementById('banner-new-label');
            var wrapper = document.getElementById('banner-wrapper');

            previewImg.src = e.target.result;
            previewImg.style.display = 'block';
            previewLabel.style.display = 'flex';
            wrapper.style.border = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
