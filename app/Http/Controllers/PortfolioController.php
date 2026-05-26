<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function search(Request $request)
    {
        $tab = $request->input('tab', 'siswa');
        
        $categories  = Category::orderBy('name')->get();
        $types       = ['poster', 'video', 'desain', 'dokumen', 'fotografi', 'tugas praktik', 'presentasi'];

        if ($tab === 'karya') {
            $query = Portfolio::with(['student', 'categories', 'latestAssessment']);

            // Search
            if ($search = $request->input('q')) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereHas('student', function ($sq) use ($search) {
                          $sq->where('name', 'like', "%{$search}%");
                      });
                });
            }

            // Filter by category
            if ($categoryId = $request->input('category')) {
                $query->whereHas('categories', fn ($q) => $q->where('categories.id', $categoryId));
            }

            // Filter by type
            if ($type = $request->input('type')) {
                $query->where('type', $type);
            }

            $portfolios = $query->orderByDesc('created_at')->paginate(12)->withQueryString();
            $students = null;
        } else {
            // Default: Siswa
            $query = \App\Models\User::where('role', 'student')
                ->where('is_active', true)
                ->with(['studentProfile', 'skills', 'portfolios']);

            if ($search = $request->input('q')) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhereHas('studentProfile', function ($sq) use ($search) {
                          $sq->where('major', 'like', "%{$search}%")
                            ->orWhere('class_name', 'like', "%{$search}%")
                            ->orWhere('bio', 'like', "%{$search}%");
                      })
                      ->orWhereHas('skills', function ($skq) use ($search) {
                          $skq->where('name', 'like', "%{$search}%");
                      });
                });
            }

            $students = $query->orderBy('name')->paginate(12)->withQueryString();
            $portfolios = null;
        }

        return view('public.portfolio-search', compact('portfolios', 'students', 'categories', 'types', 'tab'));
    }

    public function show(Portfolio $portfolio)
    {
        $portfolio->increment('view_count');
        $portfolio->load(['student.studentProfile', 'categories', 'assessments.admin']);

        return view('public.portfolio-detail', compact('portfolio'));
    }
}
