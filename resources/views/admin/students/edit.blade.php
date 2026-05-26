@extends('layouts.admin')
@section('title', 'Edit Profil Siswa')
@section('page-title', 'Edit Profil — ' . $user->name)

@section('content')
<a href="{{ route('admin.students.show', $user->id) }}" class="text-sm text-primary mb-2" style="display:inline-block;">← Kembali ke Detail Siswa</a>

@if(session('success'))
    <div class="alert alert-success" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);color:#34d399;padding:0.75rem 1rem;border-radius:0.5rem;margin-bottom:1rem;font-size:0.875rem;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#fca5a5;padding:0.75rem 1rem;border-radius:0.5rem;margin-bottom:1rem;font-size:0.875rem;">
        <ul style="margin:0;padding-left:1.5rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card" style="max-width:640px;">
    <h2 style="margin-bottom:1.5rem;">Edit Profil Siswa</h2>

    <form action="{{ route('admin.students.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="{{ $user->email }}" disabled style="opacity:0.6;cursor:not-allowed;">
            <small style="color:#64748b;font-size:0.75rem;">Email tidak dapat diubah.</small>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Kelas</label>
                <select name="class_name" class="form-control form-select">
                    <option value="">— Pilih Kelas —</option>
                    @foreach(['X', 'XI', 'XII'] as $kelas)
                        <option value="{{ $kelas }}" {{ old('class_name', $user->studentProfile?->class_name) === $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Program Keahlian / Jurusan</label>
                <select name="major" class="form-control form-select">
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

        <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.students.show', $user->id) }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
