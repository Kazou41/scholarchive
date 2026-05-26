<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpMessage;
use App\Models\Portfolio;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students'  => User::where('role', 'student')->count(),
            'total_works'     => Portfolio::count(),
            'assessed_works'  => Portfolio::has('assessments')->count(),
            'total_messages'  => HelpMessage::count(),
            'new_messages'    => HelpMessage::where('status', 'new')->count(),
        ];

        $recentWorks = Portfolio::with(['student', 'categories'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $topWorks = Portfolio::with(['student', 'latestAssessment'])
            ->where('is_featured', true)
            ->orderByDesc('view_count')
            ->take(4)
            ->get();

        // Department breakdown from real major data
        $totalProfiles = \App\Models\StudentProfile::count();
        $departmentBreakdown = \App\Models\StudentProfile::select('major', \DB::raw('count(*) as total'))
            ->whereNotNull('major')
            ->where('major', '!=', '')
            ->groupBy('major')
            ->orderByDesc('total')
            ->get()
            ->map(function ($item) use ($totalProfiles) {
                return [
                    'name'  => $item->major,
                    'count' => $item->total,
                    'pct'   => $totalProfiles > 0 ? round(($item->total / $totalProfiles) * 100) : 0,
                ];
            });

        return view('admin.dashboard', compact('stats', 'recentWorks', 'topWorks', 'departmentBreakdown'));
    }

    public function getNotifications()
    {
        $lastRead = session('last_read_notifications_at') ? \Carbon\Carbon::parse(session('last_read_notifications_at')) : null;

        // 1. Unassessed portfolios
        $pendingPortfolios = \App\Models\Portfolio::with('student')
            ->doesntHave('assessments')
            ->orderByDesc('created_at')
            ->get();

        // 2. Unread messages
        $unreadMessages = \App\Models\HelpMessage::where('status', 'new')
            ->orderByDesc('created_at')
            ->get();

        // 3. New students (last 7 days)
        $newStudents = \App\Models\User::where('role', 'student')
            ->where('created_at', '>=', now()->subDays(7))
            ->orderByDesc('created_at')
            ->get();

        $notifications = [];
        $unreadCount = 0;

        foreach ($pendingPortfolios as $portfolio) {
            $isUnread = !$lastRead || $portfolio->created_at->gt($lastRead);
            if ($isUnread) $unreadCount++;
            $notifications[] = [
                'id' => 'portfolio_' . $portfolio->id,
                'type' => 'portfolio',
                'title' => 'Karya baru diunggah',
                'body' => $portfolio->title . ' oleh ' . ($portfolio->student->name ?? 'Siswa'),
                'time' => $portfolio->created_at->diffForHumans(),
                'created_at' => $portfolio->created_at->toIso8601String(),
                'url' => route('admin.works.show', $portfolio->id),
                'unread' => $isUnread,
            ];
        }

        foreach ($unreadMessages as $msg) {
            $isUnread = !$lastRead || $msg->created_at->gt($lastRead);
            if ($isUnread) $unreadCount++;
            $notifications[] = [
                'id' => 'message_' . $msg->id,
                'type' => 'message',
                'title' => 'Pesan baru diterima',
                'body' => 'Dari ' . $msg->name . ': "' . \Str::limit($msg->message, 40) . '"',
                'time' => $msg->created_at->diffForHumans(),
                'created_at' => $msg->created_at->toIso8601String(),
                'url' => route('admin.feedback.index'),
                'unread' => $isUnread,
            ];
        }

        foreach ($newStudents as $student) {
            $isUnread = !$lastRead || $student->created_at->gt($lastRead);
            if ($isUnread) $unreadCount++;
            $notifications[] = [
                'id' => 'student_' . $student->id,
                'type' => 'student',
                'title' => 'Siswa baru terdaftar',
                'body' => $student->name . ' (' . $student->email . ')',
                'time' => $student->created_at->diffForHumans(),
                'created_at' => $student->created_at->toIso8601String(),
                'url' => route('admin.students.show', $student->id),
                'unread' => $isUnread,
            ];
        }

        // Sort by created_at desc
        usort($notifications, function ($a, $b) {
            return strcmp($b['created_at'], $a['created_at']);
        });

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    public function markNotificationsRead()
    {
        session(['last_read_notifications_at' => now()->toDateTimeString()]);
        return response()->json(['success' => true]);
    }

    public function searchApi(\Illuminate\Http\Request $request)
    {
        $q = $request->input('q');
        if (empty($q) || strlen($q) < 2) {
            return response()->json(['students' => [], 'portfolios' => []]);
        }

        $students = \App\Models\User::where('role', 'student')
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
            })
            ->with('studentProfile')
            ->take(5)
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'email' => $student->email,
                    'class' => $student->studentProfile->class_name ?? '',
                    'major' => $student->studentProfile->major ?? '',
                    'url' => route('admin.students.show', $student->id),
                ];
            });

        $portfolios = \App\Models\Portfolio::where('title', 'like', "%{$q}%")
            ->orWhere('description', 'like', "%{$q}%")
            ->with('student')
            ->take(5)
            ->get()
            ->map(function ($portfolio) {
                return [
                    'id' => $portfolio->id,
                    'title' => $portfolio->title,
                    'student_name' => $portfolio->student->name ?? 'Siswa',
                    'url' => route('admin.works.show', $portfolio->id),
                ];
            });

        return response()->json([
            'students' => $students,
            'portfolios' => $portfolios,
        ]);
    }
}
