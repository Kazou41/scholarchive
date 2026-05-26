@extends('layouts.app')
@section('title', 'Buat CV — Scholarchive')

@section('content')
<section class="dk-page">
    <div class="dk-arc"></div>
    <div class="container" style="max-width:1100px;position:relative;z-index:1;">
        <a href="{{ route('home') }}" class="dk-back-link animate-item delay-1">← Kembali ke Beranda</a>

        <div style="display:grid;grid-template-columns:1fr 1.5fr;gap:1.5rem;">
            {{-- Left: Settings --}}
            <div class="animate-item delay-2">
                <div class="dk-card" style="margin-bottom:1rem;">
                    <h3 class="dk-card-title" style="font-size:1.125rem;margin-bottom:1rem;">Pengaturan CV</h3>
                    <div class="dk-form-group">
                        <label class="dk-label">Templat</label>
                        <select id="cv-template" class="dk-input dk-select">
                            <option value="professional">Profesional — Bersih & Modern</option>
                            <option value="creative">Kreatif — Berwarna & Berani</option>
                        </select>
                    </div>
                    <div class="dk-form-group">
                        <label class="dk-label">Gaya Ringkasan AI</label>
                        <select id="cv-style" class="dk-input dk-select">
                            <option value="professional">Profesional & Formal</option>
                            <option value="creative">Kreatif & Ekspresif</option>
                            <option value="concise">Ringkas & Langsung</option>
                        </select>
                    </div>
                    <button id="btn-generate-ai" class="dk-btn-primary" style="width:100%;justify-content:center;gap:0.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                        <span id="btn-generate-text">Buat dengan AI</span>
                    </button>
                </div>

                <div class="dk-card">
                    <h3 class="dk-card-title" style="font-size:1.125rem;margin-bottom:1rem;">Pilih Karya untuk CV</h3>
                    @forelse($user->portfolios as $work)
                    <label class="cv-work-item">
                        <input type="checkbox" class="work-checkbox" name="selected_works[]" value="{{ $work->id }}" checked>
                        <div class="cv-work-checkbox-custom">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:0.9375rem;font-weight:600;color:#f1f5f9;margin-bottom:0.125rem;">{{ $work->title }}</div>
                            <div style="font-size:0.75rem;color:#94a3b8;display:flex;gap:0.5rem;align-items:center;">
                                <span>{{ $work->categories->pluck('name')->join(', ') }}</span>
                                @if($work->latestAssessment)
                                <span style="background:rgba(16,185,129,0.15);color:#34d399;padding:0.125rem 0.375rem;border-radius:0.25rem;font-weight:600;">Nilai: {{ $work->latestAssessment->score }}</span>
                                @endif
                            </div>
                        </div>
                    </label>
                    @empty
                        <p style="font-size:0.875rem;color:#64748b;padding:0.5rem 0;">Belum ada karya yang diunggah.</p>
                    @endforelse
                </div>
            </div>

            {{-- Right: CV Preview --}}
            <div class="cv-preview-card animate-item delay-3" id="cv-preview-card">
                <div style="text-align:center;margin-bottom:2rem;padding-bottom:1.5rem;border-bottom:3px solid #6366f1;">
                    <h1 style="font-size:1.75rem;margin-bottom:0.25rem;color:#f1f5f9;">{{ $user->name }}</h1>
                    <p style="font-size:0.8125rem;color:#94a3b8;">{{ $user->email }} @if($user->studentProfile?->phone) · {{ $user->studentProfile->phone }} @endif @if($user->studentProfile?->address) · {{ $user->studentProfile->address }} @endif</p>
                </div>

                <div class="cv-section">
                    <h3 class="cv-section-title">Ringkasan Profesional</h3>
                    <p id="cv-summary-text" style="font-size:0.875rem;color:#cbd5e1;line-height:1.7;">{{ $user->studentProfile?->bio ?? 'Klik "Buat dengan AI" untuk membuat ringkasan profesional berdasarkan data portofolio Anda.' }}</p>
                </div>

                <div class="cv-section">
                    <h3 class="cv-section-title">Keahlian</h3>
                    <div style="display:flex;flex-wrap:wrap;gap:0.375rem;">
                        @foreach($user->skills as $skill)
                        <span class="cv-skill-tag">{{ $skill->name }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="cv-section">
                    <h3 class="cv-section-title">Proyek Terpilih</h3>
                    @foreach($user->portfolios->take(5) as $project)
                    <div class="cv-project-item" data-work-id="{{ $project->id }}" style="margin-bottom:1rem;">
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <span style="font-size:0.875rem;font-weight:700;color:#e2e8f0;">{{ $project->title }}</span>
                            @if($project->latestAssessment)
                            <span class="cv-score-badge">Nilai: {{ $project->latestAssessment->score }}</span>
                            @endif
                        </div>
                        <p style="font-size:0.75rem;color:#94a3b8;line-height:1.6;margin-top:0.25rem;">{{ Str::limit($project->description, 150) }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="cv-section">
                    <h3 class="cv-section-title">Pendidikan</h3>
                    <div style="font-size:0.875rem;color:#e2e8f0;font-weight:600;">SMKN 3 Yogyakarta</div>
                    <div style="font-size:0.75rem;color:#94a3b8;">{{ $user->studentProfile?->class_name ?? 'Siswa' }} · {{ $user->studentProfile?->major ?? 'Umum' }}</div>
                </div>

                <div style="text-align:center;margin-top:2rem;">
                    <button id="btn-download-pdf" class="dk-btn-primary" style="gap:0.5rem;padding:0.875rem 2rem;font-size:1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        <span id="btn-download-text">Unduh sebagai PDF</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Reuse dk-page, dk-arc, dk-card, dk-input etc from create-portfolio */
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
    padding: 1.5rem;
    backdrop-filter: blur(12px);
}
.dk-card-title {
    font-weight: 700;
    color: #f1f5f9;
}
.dk-form-group { margin-bottom: 1rem; }
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
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23818cf8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 14px;
    padding-right: 2.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
.dk-select:hover {
    border-color: rgba(99, 102, 241, 0.4);
    background: rgba(30, 41, 59, 0.6);
}
.dk-select option { background: #1e293b; color: #e2e8f0; }
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
.dk-btn-primary:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Work list items */
.cv-work-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    margin-bottom: 0.75rem;
    background: rgba(30, 41, 59, 0.3);
    border: 1px solid rgba(148, 163, 184, 0.1);
    border-radius: 0.75rem;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}
.cv-work-item:hover {
    background: rgba(30, 41, 59, 0.6);
    border-color: rgba(99, 102, 241, 0.3);
}
.cv-work-item:has(.work-checkbox:checked) {
    background: rgba(99, 102, 241, 0.1);
    border-color: rgba(99, 102, 241, 0.4);
}
.work-checkbox { display: none; }
.cv-work-checkbox-custom {
    width: 22px;
    height: 22px;
    border: 2px solid rgba(148, 163, 184, 0.3);
    border-radius: 0.375rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    background: rgba(15, 23, 42, 0.4);
    margin-top: 0.125rem;
    flex-shrink: 0;
}
.cv-work-checkbox-custom svg {
    width: 14px;
    height: 14px;
    color: white;
    opacity: 0;
    transition: opacity 0.2s, transform 0.2s;
    transform: scale(0.5);
}
.work-checkbox:checked + .cv-work-checkbox-custom {
    background: #6366f1;
    border-color: #6366f1;
    box-shadow: 0 0 10px rgba(99, 102, 241, 0.4);
}
.work-checkbox:checked + .cv-work-checkbox-custom svg {
    opacity: 1;
    transform: scale(1);
}

/* AI Loading */
.ai-loading {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #818cf8;
    font-weight: 500;
    animation: ai-pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
@keyframes ai-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: .5; }
}

/* CV Preview Card - slightly lighter for paper feel */
.cv-preview-card {
    background: rgba(22, 33, 50, 0.7);
    border: 1px solid rgba(148, 163, 184, 0.1);
    border-radius: 1rem;
    padding: 2.5rem;
    min-height: 700px;
    backdrop-filter: blur(12px);
}
.cv-section { margin-bottom: 1.5rem; }
.cv-section-title {
    color: #818cf8;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
    padding-bottom: 0.375rem;
    border-bottom: 1px solid rgba(148, 163, 184, 0.1);
    font-weight: 700;
}
.cv-skill-tag {
    padding: 0.25rem 0.625rem;
    background: rgba(99, 102, 241, 0.1);
    border-radius: 0.25rem;
    font-size: 0.75rem;
    color: #a5b4fc;
    font-weight: 500;
}
.cv-score-badge {
    font-size: 0.6875rem;
    padding: 0.2rem 0.5rem;
    background: rgba(16, 185, 129, 0.15);
    color: #34d399;
    border-radius: 999px;
    font-weight: 600;
}

@media (max-width: 768px) {
    .dk-page { padding: 1.5rem 0 3rem; }
    .dk-card { padding: 1.25rem; }
    .cv-preview-card { padding: 1.5rem; min-height: auto; }
    .dk-arc { width: 600px; height: 600px; top: -250px; }
    div[style*="grid-template-columns:1fr 1.5fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var btnAi       = document.getElementById('btn-generate-ai');
    var btnDownload = document.getElementById('btn-download-pdf');
    var summaryEl   = document.getElementById('cv-summary-text');
    var aiTextEl    = document.getElementById('btn-generate-text');
    var dlTextEl    = document.getElementById('btn-download-text');

    // --- Collect selected works ---
    function getSelectedWorks() {
        var checked = document.querySelectorAll('.work-checkbox:checked');
        var ids = [];
        checked.forEach(function(cb) { ids.push(parseInt(cb.value)); });
        return ids;
    }

    // --- Generate AI Summary ---
    var aiTypingTimeout = null;
    
    btnAi.addEventListener('click', function() {
        var style    = document.getElementById('cv-style').value;
        var selected = getSelectedWorks();

        btnAi.disabled = true;
        aiTextEl.textContent = 'Sedang membuat...';
        summaryEl.innerHTML = '<span class="ai-loading"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg> AI sedang menganalisis portofolio Anda...</span>';
        
        if (aiTypingTimeout) clearTimeout(aiTypingTimeout);

        fetch('{{ route("student.generate-cv.ai") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                style: style,
                selected_works: selected
            })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            var text = data.summary;
            summaryEl.textContent = '';
            var i = 0;
            function typeChar() {
                if (i < text.length) {
                    summaryEl.textContent += text.charAt(i);
                    i++;
                    aiTypingTimeout = setTimeout(typeChar, 12);
                }
            }
            typeChar();
        })
        .catch(function(err) {
            alert('Gagal generate summary. Silakan coba lagi.');
            console.error(err);
        })
        .finally(function() {
            btnAi.disabled = false;
            aiTextEl.textContent = 'Buat dengan AI';
        });
    });

    // --- Download as PDF ---
    btnDownload.addEventListener('click', function() {
        var selected = getSelectedWorks();
        var summary  = summaryEl.textContent;

        btnDownload.disabled = true;
        dlTextEl.textContent = 'Menyiapkan PDF...';

        fetch('{{ route("student.download-cv") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/pdf',
            },
            body: JSON.stringify({
                selected_works: selected,
                summary: summary
            })
        })
        .then(function(res) {
            if (!res.ok) throw new Error('PDF generation failed');
            var cd = res.headers.get('Content-Disposition');
            var filename = 'cv.pdf';
            if (cd) {
                var match = cd.match(/filename="?([^";\n]+)"?/);
                if (match) filename = match[1];
            }
            return res.blob().then(function(blob) { return { blob: blob, filename: filename }; });
        })
        .then(function(result) {
            var url = window.URL.createObjectURL(result.blob);
            var a   = document.createElement('a');
            a.href  = url;
            a.download = result.filename;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            a.remove();
        })
        .catch(function(err) {
            alert('Gagal membuat PDF. Silakan coba lagi.');
            console.error(err);
        })
        .finally(function() {
            btnDownload.disabled = false;
            dlTextEl.textContent = 'Unduh sebagai PDF';
        });
    });

    // --- Toggle project visibility based on checkboxes ---
    document.querySelectorAll('.work-checkbox').forEach(function(cb) {
        cb.addEventListener('change', function() {
            var workId = this.value;
            var projectEl = document.querySelector('.cv-project-item[data-work-id="' + workId + '"]');
            if (projectEl) {
                projectEl.style.display = this.checked ? 'block' : 'none';
            }
        });
    });
});
</script>
@endsection
