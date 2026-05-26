<?php

namespace App\Http\Controllers;

use App\Models\User;

class StudentPublicController extends Controller
{
    public function show(User $user)
    {
        if (!$user->isStudent()) abort(404);

        $user->load(['studentProfile', 'skills', 'portfolios' => function ($q) {
            $q->with(['categories', 'latestAssessment'])->orderByDesc('created_at');
        }]);

        return view('public.student-profile', compact('user'));
    }
}
