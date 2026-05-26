@extends('layouts.app')
@section('title', 'Bantuan & Kontak — Scholarchive')

@section('content')
{{-- Hero Section --}}
<section class="help-hero">
    <div class="help-hero-inner">
        {{-- Left --}}
        <div class="help-hero-left animate-item delay-1">
            <h1 class="help-hero-title">Ada yang bisa<br>kami bantu?</h1>
            <p class="help-hero-desc">Tim kami siap membantu kamu. Lihat pertanyaan yang sering diajukan di bawah atau langsung kirimkan pesan kepada kami.</p>
            <div class="help-hero-actions">
                <a href="#faq-section" class="help-btn-primary">Lihat FAQ</a>
            </div>
        </div>
        {{-- Right: Contact Form --}}
        <div class="help-hero-right animate-item delay-2" id="contact-form">
            <div class="help-form-card">
                @if(session('success'))
                    <div style="background:#dcfce7;color:#166534;padding:0.75rem;border-radius:0.5rem;margin-bottom:1rem;font-size:0.875rem;">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('help.store') }}" method="POST">
                    @csrf
                    <div class="help-form-row">
                        <div class="help-form-group">
                            <input type="email" name="email" class="help-input" placeholder="Email Kamu" required>
                        </div>
                        <div class="help-form-group">
                            <input type="text" name="name" class="help-input" placeholder="Nama Lengkap" required>
                        </div>
                    </div>
                    <div class="help-form-group">
                        <textarea name="message" class="help-input help-textarea" placeholder="Tulis Pesanmu..." rows="5" required></textarea>
                    </div>
                    <button type="submit" class="help-submit-btn">Kirim</button>
                </form>
                {{-- Contact Info --}}
                <div class="help-contact-info">
                    <div class="help-contact-left">
                        <span>info@scholarchive.id</span>
                        <span>+62 274-513503</span>
                    </div>
                    <div class="help-contact-right">
                        <span>SMKN 3 Yogyakarta,</span>
                        <span>Jl.RW. Monginsidi No. 2</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FAQ Section --}}
<section class="help-faq-section" id="faq-section">
    <div class="help-faq-inner">
        <div class="help-faq-left animate-item delay-3">
            <h2 class="help-faq-title">Pertanyaan<br>yang sering<br><span class="help-faq-accent">ditanyakan</span></h2>
        </div>
        <div class="help-faq-right animate-item delay-4">
            <div class="help-faq-item active">
                <button class="help-faq-question" onclick="toggleFaq(this)">
                    <span class="help-faq-icon">−</span>
                    <span>Apa itu Scholarchive?</span>
                </button>
                <div class="help-faq-answer">
                    <p>Scholarchive adalah platform portofolio digital yang dirancang khusus untuk siswa SMK. Platform ini memungkinkan siswa untuk mengunggah, mengelola, dan memamerkan karya terbaik mereka secara online.</p>
                </div>
            </div>
            <div class="help-faq-item">
                <button class="help-faq-question" onclick="toggleFaq(this)">
                    <span class="help-faq-icon">+</span>
                    <span>Bagaimana cara kerja Scholarchive?</span>
                </button>
                <div class="help-faq-answer">
                    <p>Siswa mendaftar dengan akun sekolah, lalu dapat mengunggah karya portofolio, mengelola profil, menambahkan keahlian, dan membuat CV secara otomatis. Guru dapat menilai dan memberikan umpan balik pada setiap karya.</p>
                </div>
            </div>
            <div class="help-faq-item">
                <button class="help-faq-question" onclick="toggleFaq(this)">
                    <span class="help-faq-icon">+</span>
                    <span>Jenis karya apa saja yang bisa diunggah?</span>
                </button>
                <div class="help-faq-answer">
                    <p>Kamu dapat mengunggah berbagai jenis karya seperti desain grafis, proyek pemrograman, fotografi, video, tulisan, dan karya kreatif lainnya dalam format gambar, PDF, atau dokumen.</p>
                </div>
            </div>
            <div class="help-faq-item">
                <button class="help-faq-question" onclick="toggleFaq(this)">
                    <span class="help-faq-icon">+</span>
                    <span>Apakah Scholarchive bisa diakses oleh publik?</span>
                </button>
                <div class="help-faq-answer">
                    <p>Ya, profil dan portofolio siswa dapat dilihat oleh pengguna publik. Halaman beranda menampilkan karya-karya unggulan dari seluruh siswa yang terdaftar.</p>
                </div>
            </div>
            <div class="help-faq-item">
                <button class="help-faq-question" onclick="toggleFaq(this)">
                    <span class="help-faq-icon">+</span>
                    <span>Bagaimana cara membuat CV di Scholarchive?</span>
                </button>
                <div class="help-faq-answer">
                    <p>Scholarchive memiliki fitur Generate CV yang secara otomatis membuat CV profesional berdasarkan data profil, keahlian, dan portofolio kamu. Kamu juga bisa mengunduhnya dalam format PDF.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ========== HELP HERO ========== */
.help-hero {
    background: linear-gradient(135deg, #0a0e1a 0%, #111827 40%, #0f172a 100%);
    padding: 5rem 2rem 4rem;
    margin-top: -2rem;
}
.help-hero-inner {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: center;
}
.help-hero-title {
    font-size: 3rem;
    font-weight: 800;
    color: #ffffff;
    line-height: 1.15;
    margin-bottom: 1.25rem;
    letter-spacing: -0.02em;
}
.help-hero-desc {
    color: #94a3b8;
    font-size: 1rem;
    line-height: 1.7;
    margin-bottom: 2rem;
    max-width: 420px;
}
.help-hero-actions {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}
.help-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #ffffff !important;
    padding: 0.75rem 1.75rem;
    border-radius: 999px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: transform 0.2s, box-shadow 0.2s;
}
.help-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
    color: #ffffff !important;
}
.help-btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #e2e8f0;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: color 0.2s;
}
.help-btn-ghost:hover { color: #8b5cf6; }

/* ========== FORM CARD ========== */
.help-form-card {
    background: rgba(30, 41, 59, 0.6);
    border: 1px solid rgba(99, 102, 241, 0.15);
    backdrop-filter: blur(12px);
    border-radius: 1.25rem;
    padding: 2rem;
}
.help-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.875rem;
    margin-bottom: 0.875rem;
}
.help-form-group { margin-bottom: 0; }
.help-input {
    width: 100%;
    background: rgba(15, 23, 42, 0.6);
    border: 1.5px solid rgba(148, 163, 184, 0.12);
    border-radius: 0.625rem;
    padding: 0.8rem 1rem;
    font-size: 0.9rem;
    color: #e2e8f0;
    font-family: 'Poppins', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.help-input::placeholder { color: rgba(148, 163, 184, 0.5); }
.help-input:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
    background: rgba(15, 23, 42, 0.8);
}
.help-textarea {
    resize: vertical;
    min-height: 120px;
    margin-bottom: 0.875rem;
}
.help-submit-btn {
    width: 100%;
    padding: 0.85rem;
    border: none;
    border-radius: 0.625rem;
    font-size: 1rem;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
    color: #fff;
    background: linear-gradient(135deg, #6366f1 0%, #a78bfa 50%, #c084fc 100%);
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}
.help-submit-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(139, 92, 246, 0.35);
}
.help-contact-info {
    display: flex;
    justify-content: space-between;
    margin-top: 1.5rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(148, 163, 184, 0.15);
}
.help-contact-left,
.help-contact-right {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}
.help-contact-left span,
.help-contact-right span {
    font-size: 0.8rem;
    color: #94a3b8;
}
.help-contact-right { text-align: right; }

/* ========== FAQ SECTION ========== */
.help-faq-section {
    background: linear-gradient(180deg, #0f172a 0%, #111827 100%);
    padding: 5rem 2rem;
    border-top: 1px solid rgba(99, 102, 241, 0.1);
}
.help-faq-inner {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 0.8fr 1.2fr;
    gap: 4rem;
    align-items: start;
}
.help-faq-title {
    font-size: 2.75rem;
    font-weight: 800;
    color: #f1f5f9;
    line-height: 1.15;
    letter-spacing: -0.02em;
}
.help-faq-accent {
    background: linear-gradient(135deg, #6366f1, #a78bfa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-style: italic;
}
.help-faq-item {
    border-bottom: 1px solid rgba(148, 163, 184, 0.15);
}
.help-faq-item:last-child { border-bottom: none; }
.help-faq-question {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 1rem;
    background: none;
    border: none;
    padding: 1.25rem 0;
    cursor: pointer;
    text-align: left;
    font-family: 'Poppins', sans-serif;
    font-size: 1rem;
    font-weight: 600;
    color: #e2e8f0;
    transition: all 0.2s;
}
.help-faq-question:hover {
    color: #ffffff;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.15);
}
.help-faq-question:hover .help-faq-icon {
    border-color: #818cf8;
    color: #ffffff;
    background: rgba(99, 102, 241, 0.15);
    box-shadow: 0 0 10px rgba(129, 140, 248, 0.2);
}
.help-faq-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 2px solid rgba(148, 163, 184, 0.2);
    font-size: 1.1rem;
    font-weight: 600;
    color: #a78bfa;
    flex-shrink: 0;
    transition: all 0.2s;
}
.help-faq-item.active .help-faq-icon {
    background: #6366f1;
    border-color: #6366f1;
    color: #fff;
}
.help-faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s ease, padding 0.35s ease;
    padding: 0 0 0 3rem;
}
.help-faq-item.active .help-faq-answer {
    max-height: 300px;
    padding: 0 0 1.25rem 3rem;
}
.help-faq-answer p {
    color: #94a3b8;
    font-size: 0.9rem;
    line-height: 1.7;
    font-style: italic;
}

/* ========== RESPONSIVE ========== */
@media (max-width: 768px) {
    .help-hero-inner {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    .help-hero-title { font-size: 2.25rem; }
    .help-faq-inner {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    .help-faq-title { font-size: 2rem; }
    .help-form-row { grid-template-columns: 1fr; }
    .help-contact-info { flex-direction: column; gap: 0.75rem; }
    .help-contact-right { text-align: left; }
}
</style>

<script>
function toggleFaq(btn) {
    const item = btn.closest('.help-faq-item');
    const wasActive = item.classList.contains('active');

    // Close all
    document.querySelectorAll('.help-faq-item').forEach(el => {
        el.classList.remove('active');
        el.querySelector('.help-faq-icon').textContent = '+';
    });

    // Open clicked one (if it wasn't active)
    if (!wasActive) {
        item.classList.add('active');
        item.querySelector('.help-faq-icon').textContent = '−';
    }
}
</script>
@endsection
