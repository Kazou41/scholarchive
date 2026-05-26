<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // ── Relationships ──

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class, 'student_id');
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class, 'student_id');
    }

    public function assessmentsGiven()
    {
        return $this->hasMany(PortfolioAssessment::class, 'admin_id');
    }

    public function cvDocuments()
    {
        return $this->hasMany(CvDocument::class, 'student_id');
    }

    // ── Helpers ──

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }
}
