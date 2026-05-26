<?php

namespace App\Http\Controllers;

use App\Models\HelpMessage;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        return view('public.help');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        HelpMessage::create($validated);

        return back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera merespons.');
    }
}
