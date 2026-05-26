<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'student')->with(['studentProfile', 'portfolios']);

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $students = $query->orderByDesc('created_at')->paginate(15);

        return view('admin.students.index', compact('students'));
    }

    public function show(User $user)
    {
        if (!$user->isStudent()) abort(404);

        $user->load(['studentProfile', 'skills', 'portfolios' => function ($q) {
            $q->with(['categories', 'latestAssessment'])->orderByDesc('created_at');
        }]);

        return view('admin.students.show', compact('user'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:6',
            'class_name' => 'nullable|string|max:50',
            'major'      => 'nullable|string|max:100',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'],
            'role'     => 'student',
        ]);

        StudentProfile::create([
            'user_id'    => $user->id,
            'class_name' => $validated['class_name'] ?? null,
            'major'      => $validated['major'] ?? null,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun {$user->name} berhasil {$status}.");
    }

    public function edit(User $user)
    {
        if (!$user->isStudent()) abort(404);
        $user->load('studentProfile');

        return view('admin.students.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!$user->isStudent()) abort(404);

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'class_name' => 'nullable|string|max:50',
            'major'      => 'nullable|string|max:255',
        ]);

        $user->update(['name' => $validated['name']]);

        $user->studentProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'class_name' => $validated['class_name'],
                'major'      => $validated['major'],
            ]
        );

        return redirect()->route('admin.students.show', $user->id)
            ->with('success', "Profil {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        if (!$user->isStudent()) abort(404);

        $name = $user->name;

        // Delete related data
        $user->skills()->delete();
        $user->portfolios()->each(function ($portfolio) {
            $portfolio->categories()->detach();
            $portfolio->assessments()->delete();
            $portfolio->delete();
        });
        $user->studentProfile?->delete();
        $user->delete();

        return redirect()->route('admin.students.index')
            ->with('success', "Akun siswa {$name} beserta seluruh datanya berhasil dihapus.");
    }
}
