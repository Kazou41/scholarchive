<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\PortfolioAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkController extends Controller
{
    public function index(Request $request)
    {
        $query = Portfolio::with(['student', 'categories', 'latestAssessment']);

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('student', fn ($sq) => $sq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->input('status') === 'assessed') {
            $query->has('assessments');
        } elseif ($request->input('status') === 'pending') {
            $query->doesntHave('assessments');
        }

        $works = $query->orderByDesc('created_at')->paginate(15);

        return view('admin.works.index', compact('works'));
    }

    public function show(Portfolio $portfolio)
    {
        $portfolio->load(['student.studentProfile', 'categories', 'assessments.admin']);

        return view('admin.works.show', compact('portfolio'));
    }

    public function assess(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'score'    => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string|max:2000',
        ]);

        PortfolioAssessment::updateOrCreate(
            [
                'portfolio_id' => $portfolio->id,
                'admin_id'     => Auth::id(),
            ],
            [
                'score'       => $validated['score'],
                'feedback'    => $validated['feedback'],
                'assessed_at' => now(),
            ]
        );

        return back()->with('success', 'Penilaian berhasil disimpan!');
    }

    public function toggleFeatured(Portfolio $portfolio)
    {
        if (!$portfolio->is_featured) {
            $featuredCount = Portfolio::where('is_featured', true)->count();
            if ($featuredCount >= 4) {
                return back()->with('error', 'Gagal: Maksimal karya unggulan (Featured Gallery) dibatasi 4 karya saja.');
            }
        }

        $portfolio->update(['is_featured' => !$portfolio->is_featured]);
        $status = $portfolio->is_featured ? 'ditambahkan ke' : 'dihapus dari';

        return back()->with('success', "Karya berhasil {$status} Featured Gallery.");
    }

    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();

        return redirect()->route('admin.works.index')->with('success', 'Karya berhasil dihapus.');
    }
}
