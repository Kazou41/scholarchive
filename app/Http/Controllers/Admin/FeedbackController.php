<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpMessage;

class FeedbackController extends Controller
{
    public function index()
    {
        $messages = HelpMessage::orderByDesc('created_at')->paginate(15);

        return view('admin.feedback.index', compact('messages'));
    }

    public function show(HelpMessage $message)
    {
        if ($message->status === 'new') {
            $message->update(['status' => 'read']);
        }

        return view('admin.feedback.show', compact('message'));
    }

    public function resolve(HelpMessage $message)
    {
        $message->update(['status' => 'resolved']);

        return back()->with('success', 'Pesan berhasil ditandai sebagai selesai.');
    }
}
