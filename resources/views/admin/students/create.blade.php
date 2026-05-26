@extends('layouts.admin')
@section('title', 'Tambah Siswa Baru')
@section('page-title', 'Tambah Siswa Baru')

@section('content')
<a href="{{ route('admin.students.index') }}" class="text-sm text-primary mb-2" style="display:inline-block;">← Kembali ke Daftar Siswa</a>

<div class="card" style="max-width:640px;">
    <h2 style="margin-bottom:1.5rem;">Tambah Siswa Baru</h2>
    <form>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" placeholder="Masukkan nama siswa">
            </div>
            <div class="form-group">
                <label class="form-label">Email Sekolah</label>
                <input type="hidden" name="email" id="admin-email-hidden">
                <div class="adm-email-group">
                    <input type="text" class="form-control" id="admin-email-user" placeholder="nama.siswa" autocomplete="off">
                    <div class="adm-domain-btn" id="adm-domain-toggle" onclick="admToggleDomain()">
                        <span id="adm-domain-label">@siswa.skagata.sch.id</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        <div class="adm-domain-dropdown" id="adm-domain-dropdown">
                            <button type="button" class="adm-domain-option active" onclick="admSelectDomain('@siswa.skagata.sch.id', this)">@siswa.skagata.sch.id</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Kelas</label>
                <select class="form-control form-select">
                    <option>Pilih Kelas</option>
                    <option>X</option>
                    <option>XI</option>
                    <option>XII</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Jurusan</label>
                <select class="form-control form-select">
                    <option>Pilih Jurusan</option>
                    <option>Broadcasting & Perfilman</option>
                    <option>Teknik Jaringan Komputer & Telekomunikasi</option>
                    <option>Desain Pemodelan & Informasi Bangunan</option>
                    <option>Teknik Konstruksi & Perumahan</option>
                    <option>Teknik Elektronika</option>
                    <option>Teknik Ketenagalistrikan</option>
                    <option>Teknik Otomotif</option>
                    <option>Teknik Mesin</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Kata Sandi</label>
            <input type="password" class="form-control" placeholder="Masukkan kata sandi awal">
        </div>
        <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary">Buat Akun Siswa</button>
            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<style>
.adm-email-group {
    display: flex;
    position: relative;
}
.adm-email-group .form-control {
    border-radius: 0.5rem 0 0 0.5rem !important;
    border-right: none !important;
    flex: 1;
}
.adm-email-group .form-control:focus {
    z-index: 2;
}
.adm-domain-btn {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    background: rgba(99, 102, 241, 0.12);
    border: 1px solid rgba(148, 163, 184, 0.15);
    border-left: 1px solid rgba(99, 102, 241, 0.2);
    border-radius: 0 0.5rem 0.5rem 0;
    padding: 0 0.875rem;
    color: #818cf8;
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s;
    position: relative;
}
.adm-domain-btn:hover {
    background: rgba(99, 102, 241, 0.2);
    color: #a5b4fc;
}
.adm-domain-btn svg {
    width: 12px;
    height: 12px;
    transition: transform 0.2s;
}
.adm-domain-btn.open svg {
    transform: rotate(180deg);
}
.adm-domain-dropdown {
    position: absolute;
    top: calc(100% + 4px);
    right: 0;
    min-width: 220px;
    background: rgba(22, 27, 43, 0.95);
    border: 1px solid rgba(148, 163, 184, 0.15);
    border-radius: 0.5rem;
    padding: 0.375rem;
    backdrop-filter: blur(16px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
    z-index: 20;
    display: none;
}
.adm-domain-dropdown.show {
    display: block;
    animation: admDropIn 0.15s ease-out;
}
.adm-domain-option {
    display: block;
    width: 100%;
    background: none;
    border: none;
    text-align: left;
    padding: 0.5rem 0.75rem;
    font-size: 0.8125rem;
    font-family: inherit;
    color: #e2e8f0;
    cursor: pointer;
    border-radius: 0.375rem;
    transition: all 0.15s;
}
.adm-domain-option:hover {
    background: rgba(99, 102, 241, 0.15);
    color: #818cf8;
}
.adm-domain-option.active {
    background: rgba(99, 102, 241, 0.2);
    color: #818cf8;
    font-weight: 600;
}
@keyframes admDropIn {
    from { opacity: 0; transform: translateY(-6px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<script>
var admCurrentDomain = '@siswa.skagata.sch.id';

function admToggleDomain() {
    var dd = document.getElementById('adm-domain-dropdown');
    var btn = document.getElementById('adm-domain-toggle');
    dd.classList.toggle('show');
    btn.classList.toggle('open');
}

function admSelectDomain(domain, el) {
    admCurrentDomain = domain;
    document.getElementById('adm-domain-label').textContent = domain;
    document.querySelectorAll('.adm-domain-option').forEach(function(o) { o.classList.remove('active'); });
    el.classList.add('active');
    document.getElementById('adm-domain-dropdown').classList.remove('show');
    document.getElementById('adm-domain-toggle').classList.remove('open');
}

document.addEventListener('click', function(e) {
    var btn = document.getElementById('adm-domain-toggle');
    if (btn && !btn.contains(e.target)) {
        document.getElementById('adm-domain-dropdown').classList.remove('show');
        btn.classList.remove('open');
    }
});

document.querySelector('.card form').addEventListener('submit', function(e) {
    var username = document.getElementById('admin-email-user').value.trim();
    document.getElementById('admin-email-hidden').value = username + admCurrentDomain;
});
</script>
@endsection
