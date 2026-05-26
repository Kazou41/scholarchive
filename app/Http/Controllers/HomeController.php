<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;

class HomeController extends Controller
{
    public function index()
    {
        $featuredWorks = Portfolio::with(['student', 'categories', 'latestAssessment'])
            ->where('is_featured', true)
            ->orderByDesc('view_count')
            ->take(4)
            ->get();

        return view('public.home', compact('featuredWorks'));
    }
}
