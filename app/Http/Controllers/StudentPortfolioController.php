<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Portfolio;
use App\Models\Skill;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StudentPortfolioController extends Controller
{
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('student.create-portfolio', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|string',
            'description' => 'required|string',
            'categories'  => 'required|array|min:1',
            'categories.*'=> 'exists:categories,id',
            'video_url'   => 'nullable|url|max:255',
            'file'        => 'required_without:video_url|file|max:51200', // 50MB
        ]);

        $path = null;
        $fileType = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('portfolios', 'public');
            $fileType = $file->getClientMimeType();
        }

        $portfolio = Portfolio::create([
            'student_id'  => Auth::id(),
            'title'       => $validated['title'],
            'slug'        => Str::slug($validated['title']) . '-' . Str::random(5),
            'type'        => $validated['type'],
            'description' => $validated['description'],
            'video_url'   => $validated['video_url'],
            'file_path'   => $path,
            'file_type'   => $fileType,
        ]);

        $portfolio->categories()->attach($validated['categories']);

        return redirect()->route('student.profile')->with('success', 'Karya berhasil dipublikasikan!');
    }

    public function edit(Portfolio $portfolio)
    {
        if ($portfolio->student_id !== Auth::id()) abort(403);
        $categories = Category::orderBy('name')->get();
        return view('student.edit-portfolio', compact('portfolio', 'categories'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        if ($portfolio->student_id !== Auth::id()) abort(403);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|string',
            'description' => 'required|string',
            'categories'  => 'required|array|min:1',
            'categories.*'=> 'exists:categories,id',
            'video_url'   => 'nullable|url|max:255',
            'file'        => 'nullable|file|max:51200',
        ]);

        $portfolio->update([
            'title'       => $validated['title'],
            'type'        => $validated['type'],
            'description' => $validated['description'],
            'video_url'   => $validated['video_url'],
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('portfolios', 'public');
            $portfolio->update([
                'file_path' => $path,
                'file_type' => $file->getClientMimeType(),
            ]);
        }

        $portfolio->categories()->sync($validated['categories']);

        return redirect()->route('student.profile')->with('success', 'Karya berhasil diperbarui!');
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->student_id !== Auth::id()) abort(403);
        $portfolio->delete();
        return redirect()->route('student.profile')->with('success', 'Karya berhasil dihapus.');
    }

    public function profile()
    {
        $user = Auth::user()->load(['studentProfile', 'skills', 'portfolios' => function ($q) {
            $q->with(['categories', 'latestAssessment'])->orderByDesc('created_at');
        }]);

        return view('student.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:255',
            'bio'        => 'nullable|string|max:1000',
            'class_name' => 'nullable|string|max:50',
            'major'      => 'nullable|string|max:255',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'banner'     => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $user = Auth::user();
        $user->update(['name' => $validated['name']]);

        $profileData = [
            'phone'      => $validated['phone'],
            'address'    => $validated['address'],
            'bio'        => $validated['bio'],
            'class_name' => $validated['class_name'],
            'major'      => $validated['major'],
        ];

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profiles', 'public');
            $profileData['photo'] = $path;
        }

        if ($request->hasFile('banner')) {
            $path = $request->file('banner')->store('banners', 'public');
            $profileData['banner'] = $path;
        }

        $user->studentProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function addSkill(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:100',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
        ]);

        Skill::create([
            'student_id' => Auth::id(),
            'name'       => $validated['name'],
            'level'      => $validated['level'],
        ]);

        return back()->with('success', 'Skill berhasil ditambahkan!');
    }

    public function deleteSkill(Skill $skill)
    {
        if ($skill->student_id !== Auth::id()) abort(403);
        $skill->delete();

        return back()->with('success', 'Skill berhasil dihapus.');
    }

    public function editProfile()
    {
        $user = Auth::user()->load(['studentProfile', 'skills', 'portfolios' => function ($q) {
            $q->with(['categories', 'latestAssessment'])->orderByDesc('created_at');
        }]);

        return view('student.edit-profile', compact('user'));
    }

    public function generateCv()
    {
        $user = Auth::user()->load(['studentProfile', 'skills', 'portfolios' => function ($q) {
            $q->with(['categories', 'latestAssessment'])->orderByDesc('created_at');
        }]);

        return view('student.generate-cv', compact('user'));
    }

    /**
     * Generate an AI-style professional summary from the student's data.
     * Uses smart template composition instead of an external AI API.
     */
    public function generateCvAi(Request $request)
    {
        $request->validate([
            'style'          => 'required|in:professional,creative,concise',
            'selected_works' => 'nullable|array',
        ]);

        $user = Auth::user()->load(['studentProfile', 'skills', 'portfolios' => function ($q) {
            $q->with(['categories', 'latestAssessment'])->orderByDesc('created_at');
        }]);

        $style    = $request->input('style', 'professional');
        $selected = $request->input('selected_works', $user->portfolios->pluck('id')->toArray());

        // Gather data points
        $name       = $user->name;
        $major      = $user->studentProfile?->major ?? 'General Studies';
        $className  = $user->studentProfile?->class_name ?? '';
        $skillNames = $user->skills->pluck('name')->toArray();
        $advSkills  = $user->skills->where('level', 'Advanced')->pluck('name')->toArray();
        $works      = $user->portfolios->whereIn('id', $selected);
        $workCount  = $works->count();
        $categories = $works->flatMap(fn($w) => $w->categories->pluck('name'))->unique()->values()->toArray();
        $topScore   = $works->max(fn($w) => $w->latestAssessment?->score ?? 0);
        $avgScore   = $works->count() > 0
            ? round($works->avg(fn($w) => $w->latestAssessment?->score ?? 0), 1)
            : 0;

        $summary = $this->buildAiSummary(
            $style, $name, $major, $className,
            $skillNames, $advSkills, $workCount,
            $categories, $topScore, $avgScore
        );

        return response()->json([
            'summary'        => $summary,
            'selected_works' => $selected,
        ]);
    }

    /**
     * Build a professional summary using templates and student data.
     */
    private function buildAiSummary(
        string $style,
        string $name,
        string $major,
        string $className,
        array  $skills,
        array  $advSkills,
        int    $workCount,
        array  $categories,
        float  $topScore,
        float  $avgScore
    ): string {
        $skillText = !empty($skills)
            ? implode(', ', array_slice($skills, 0, 5))
            : 'berbagai disiplin teknis dan kejuruan';

        $advText = !empty($advSkills)
            ? ' Serta memiliki keahlian tingkat lanjut (advanced) dalam ' . implode(' dan ', array_slice($advSkills, 0, 2)) . '.'
            : '';

        $catText = !empty($categories)
            ? implode(', ', array_slice($categories, 0, 3))
            : 'multi-disiplin';

        $scoreText = $topScore > 0
            ? " Portofolio yang dikerjakan mendapat pengakuan yang sangat baik dengan skor penilaian tertinggi {$topScore}"
              . ($avgScore > 0 ? " serta rata-rata evaluasi sebesar {$avgScore} dari tim penilai." : '.')
            : '';

        $schoolContext = $className ? "Siswa kelas {$className}" : "Pelajar aktif";
        $majorContext = $major !== 'General Studies' ? $major : 'Kejuruan';

        switch ($style) {
            case 'creative':
                return "Halo, saya {$name}! Seorang {$schoolContext} Program Keahlian {$majorContext} di SMK yang penuh semangat dalam mengubah ide kreatif menjadi karya nyata. "
                     . "Dengan minat dan keahlian mendalam di bidang {$skillText}, saya telah menyelesaikan {$workCount} proyek luar biasa yang mencakup kategori {$catText}.{$advText}"
                     . ($scoreText ? $scoreText : '')
                     . " Terbiasa berkarya secara otodidak maupun kolaboratif, saya memiliki semangat eksplorasi yang tinggi, berorientasi pada detail, dan siap memberikan gebrakan inovatif di dunia industri kreatif maupun teknologi.";

            case 'concise':
                return "{$schoolContext} Program Keahlian {$majorContext} dengan portofolio {$workCount} proyek di bidang {$catText}. "
                     . "Kompetensi utama: {$skillText}."
                     . ($advText ? $advText : '')
                     . ($scoreText ? ' ' . $scoreText : '')
                     . " Berdedikasi, cepat belajar, dan siap bersaing di dunia kerja profesional.";

            default: // professional
                return "{$schoolContext} Program Keahlian {$majorContext} di SMK yang memiliki dedikasi tinggi serta keahlian praktis di bidang {$skillText}.{$advText} "
                     . "Berpengalaman dalam mengerjakan {$workCount} proyek portofolio berkualitas pada kategori {$catText}. "
                     . "Terbiasa memecahkan masalah teknis dan menerapkan standar industri pada setiap tugas akhir maupun proyek pribadi."
                     . ($scoreText ? ' ' . $scoreText : '')
                     . " Saat ini sedang fokus mengembangkan portofolio dan memperdalam kompetensi keahlian. Memiliki etos kerja yang kuat, disiplin, dan mampu bekerja secara mandiri maupun dalam tim untuk berkontribusi maksimal di lingkungan perusahaan.";
        }
    }

    /**
     * Download the CV as a PDF document.
     */
    public function downloadCvPdf(Request $request)
    {
        $request->validate([
            'selected_works' => 'nullable|array',
            'summary'        => 'nullable|string|max:2000',
        ]);

        $user = Auth::user()->load(['studentProfile', 'skills', 'portfolios' => function ($q) {
            $q->with(['categories', 'latestAssessment'])->orderByDesc('created_at');
        }]);

        $selectedIds = $request->input('selected_works', $user->portfolios->pluck('id')->toArray());
        $works       = $user->portfolios->whereIn('id', $selectedIds)->values();
        $summary     = $request->input('summary', $user->studentProfile?->bio ?? 'A motivated student looking to create impactful work.');

        $pdf = Pdf::loadView('student.cv-pdf', compact('user', 'works', 'summary'));
        $pdf->setPaper('A4', 'portrait');

        $filename = Str::slug($user->name) . '-cv-' . now()->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    // ═══════════════════════════════════════
    // ACCOUNT SETTINGS
    // ═══════════════════════════════════════

    public function settings()
    {
        $user = Auth::user();
        return view('student.settings', compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        $section = $request->input('section');

        if ($section === 'email') {
            $request->validate([
                'email' => 'required|email|unique:users,email,' . $user->id,
            ], [
                'email.required' => 'Email wajib diisi.',
                'email.email'    => 'Format email tidak valid.',
                'email.unique'   => 'Email sudah digunakan oleh akun lain.',
            ]);

            $user->update(['email' => $request->email]);

            return redirect()->route('student.settings')
                ->with('success', 'Email berhasil diperbarui!');
        }

        if ($section === 'password') {
            $request->validate([
                'current_password' => 'required',
                'password'         => 'required|string|min:8|confirmed',
            ], [
                'current_password.required' => 'Password lama wajib diisi.',
                'password.required'         => 'Password baru wajib diisi.',
                'password.min'              => 'Password baru minimal 8 karakter.',
                'password.confirmed'        => 'Konfirmasi password tidak cocok.',
            ]);

            if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
            }

            $user->update([
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            ]);

            return redirect()->route('student.settings')
                ->with('success', 'Password berhasil diperbarui!');
        }

        return back();
    }
}
