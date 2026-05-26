<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CV — {{ $user->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #1e293b;
            padding: 40px 50px;
        }

        /* Header */
        .cv-header {
            text-align: center;
            padding-bottom: 14px;
            border-bottom: 3px solid #004ac6;
            margin-bottom: 20px;
        }
        .cv-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .cv-header .contact {
            font-size: 10px;
            color: #64748b;
        }
        .cv-header .contact span {
            margin: 0 4px;
        }

        /* Section */
        .cv-section {
            margin-bottom: 18px;
        }
        .cv-section-title {
            font-size: 11px;
            font-weight: 700;
            color: #004ac6;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding-bottom: 4px;
            border-bottom: 1px solid #cbd5e1;
            margin-bottom: 8px;
        }

        /* Summary */
        .cv-summary {
            font-size: 10.5px;
            line-height: 1.7;
            color: #334155;
        }

        /* Skills */
        .skills-list {
            list-style: none;
        }
        .skills-list li {
            display: inline-block;
            background: #f1f5f9;
            color: #334155;
            padding: 3px 10px;
            border-radius: 3px;
            font-size: 9.5px;
            margin: 2px 3px 2px 0;
        }

        /* Projects */
        .project-item {
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #e2e8f0;
        }
        .project-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .project-title {
            font-size: 11px;
            font-weight: 700;
            color: #0f172a;
        }
        .project-meta {
            font-size: 9.5px;
            color: #64748b;
            margin-top: 1px;
        }
        .project-desc {
            font-size: 10px;
            color: #475569;
            margin-top: 3px;
            line-height: 1.6;
        }
        .score-badge {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            font-size: 9px;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 2px;
        }

        /* Education */
        .edu-name {
            font-weight: 700;
            font-size: 11px;
            color: #0f172a;
        }
        .edu-detail {
            font-size: 10px;
            color: #64748b;
        }

        /* Footer */
        .cv-footer {
            margin-top: 24px;
            text-align: center;
            font-size: 8.5px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="cv-header">
        <h1>{{ $user->name }}</h1>
        <div class="contact">
            {{ $user->email }}
            @if($user->studentProfile?->phone)
                <span>·</span> {{ $user->studentProfile->phone }}
            @endif
            @if($user->studentProfile?->address)
                <span>·</span> {{ $user->studentProfile->address }}
            @endif
        </div>
    </div>

    {{-- Professional Summary --}}
    <div class="cv-section">
        <div class="cv-section-title">Ringkasan Profesional</div>
        <div class="cv-summary">{{ $summary }}</div>
    </div>

    {{-- Skills --}}
    @if($user->skills->count())
    <div class="cv-section">
        <div class="cv-section-title">Keahlian</div>
        <ul class="skills-list">
            @foreach($user->skills as $skill)
                <li>{{ $skill->name }} ({{ $skill->level }})</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Selected Projects --}}
    @if($works->count())
    <div class="cv-section">
        <div class="cv-section-title">Proyek Terpilih</div>
        @foreach($works as $project)
        <div class="project-item">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <span class="project-title">{{ $project->title }}</span>
                @if($project->latestAssessment)
                    <span class="score-badge">Nilai: {{ $project->latestAssessment->score }}</span>
                @endif
            </div>
            <div class="project-meta">
                {{ ucfirst($project->type) }}
                @if($project->categories->count())
                    · {{ $project->categories->pluck('name')->join(', ') }}
                @endif
                · {{ $project->created_at->format('M Y') }}
            </div>
            <div class="project-desc">{{ Str::limit($project->description, 200) }}</div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Education --}}
    <div class="cv-section">
        <div class="cv-section-title">Pendidikan</div>
        <div class="edu-name">SMKN 3 Yogyakarta</div>
        <div class="edu-detail">
            {{ $user->studentProfile?->class_name ?? 'Siswa' }}
            · {{ $user->studentProfile?->major ?? 'Umum' }}
        </div>
    </div>

    {{-- Footer --}}
    <div class="cv-footer">
        Dibuat oleh Scholarchive · {{ now()->format('d F Y') }}
    </div>

</body>
</html>
