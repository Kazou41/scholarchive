<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\WorkController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\StudentPortfolioController;
use App\Http\Controllers\StudentPublicController;
use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════
// PUBLIC ROUTES
// ══════════════════════════════════════
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/portfolio', [PortfolioController::class, 'search'])->name('portfolio.search');
Route::get('/portfolio/{portfolio:slug}', [PortfolioController::class, 'show'])->name('portfolio.detail');

Route::get('/help', [HelpController::class, 'index'])->name('help');
Route::post('/help', [HelpController::class, 'store'])->name('help.store');

// ══════════════════════════════════════
// AUTH ROUTES
// ══════════════════════════════════════
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ══════════════════════════════════════
// STUDENT ROUTES (authenticated)
// ══════════════════════════════════════
Route::prefix('student')->name('student.')->middleware(['auth', 'role:student'])->group(function () {
    Route::get('/portfolio/create', [StudentPortfolioController::class, 'create'])->name('portfolio.create');
    Route::post('/portfolio', [StudentPortfolioController::class, 'store'])->name('portfolio.store');
    Route::get('/portfolio/{portfolio}/edit', [StudentPortfolioController::class, 'edit'])->name('portfolio.edit');
    Route::put('/portfolio/{portfolio}', [StudentPortfolioController::class, 'update'])->name('portfolio.update');
    Route::delete('/portfolio/{portfolio}', [StudentPortfolioController::class, 'destroy'])->name('portfolio.destroy');
    Route::get('/my-profile', [StudentPortfolioController::class, 'profile'])->name('profile');
    Route::get('/my-profile/edit', [StudentPortfolioController::class, 'editProfile'])->name('profile.edit');
    Route::put('/my-profile', [StudentPortfolioController::class, 'updateProfile'])->name('profile.update');
    Route::post('/skills', [StudentPortfolioController::class, 'addSkill'])->name('skills.store');
    Route::delete('/skills/{skill}', [StudentPortfolioController::class, 'deleteSkill'])->name('skills.destroy');
    Route::get('/generate-cv', [StudentPortfolioController::class, 'generateCv'])->name('generate-cv');
    Route::post('/generate-cv', [StudentPortfolioController::class, 'generateCvAi'])->name('generate-cv.ai');
    Route::post('/download-cv', [StudentPortfolioController::class, 'downloadCvPdf'])->name('download-cv');
});

Route::get('/student/{user}', [StudentPublicController::class, 'show'])->name('student.public-profile');

// ══════════════════════════════════════
// ADMIN ROUTES (authenticated)
// ══════════════════════════════════════
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications/api', [DashboardController::class, 'getNotifications'])->name('notifications.api');
    Route::post('/notifications/mark-read', [DashboardController::class, 'markNotificationsRead'])->name('notifications.markRead');
    Route::get('/search/api', [DashboardController::class, 'searchApi'])->name('search.api');

    // Student management
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [AdminStudentController::class, 'create'])->name('students.create');
    Route::post('/students', [AdminStudentController::class, 'store'])->name('students.store');
    Route::get('/students/{user}', [AdminStudentController::class, 'show'])->name('students.show');
    Route::get('/students/{user}/edit', [AdminStudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{user}', [AdminStudentController::class, 'update'])->name('students.update');
    Route::patch('/students/{user}/toggle', [AdminStudentController::class, 'toggleActive'])->name('students.toggle');
    Route::delete('/students/{user}', [AdminStudentController::class, 'destroy'])->name('students.destroy');

    // Work management
    Route::get('/works', [WorkController::class, 'index'])->name('works.index');
    Route::get('/works/{portfolio}', [WorkController::class, 'show'])->name('works.show');
    Route::post('/works/{portfolio}/assess', [WorkController::class, 'assess'])->name('works.assess');
    Route::patch('/works/{portfolio}/featured', [WorkController::class, 'toggleFeatured'])->name('works.featured');
    Route::delete('/works/{portfolio}', [WorkController::class, 'destroy'])->name('works.destroy');

    // Feedback management
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/{message}', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::patch('/feedback/{message}/resolve', [FeedbackController::class, 'resolve'])->name('feedback.resolve');
});
