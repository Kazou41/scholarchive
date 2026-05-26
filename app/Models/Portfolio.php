<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    protected $fillable = [
        'student_id',
        'title',
        'slug',
        'type',
        'description',
        'file_path',
        'file_type',
        'is_featured',
        'view_count',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'view_count' => 'integer',
    ];

    // Auto-generate slug from title
    protected static function booted(): void
    {
        static::creating(function (Portfolio $portfolio) {
            if (empty($portfolio->slug)) {
                $portfolio->slug = Str::slug($portfolio->title) . '-' . Str::random(5);
            }
        });
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'portfolio_categories');
    }

    public function assessments()
    {
        return $this->hasMany(PortfolioAssessment::class);
    }

    public function latestAssessment()
    {
        return $this->hasOne(PortfolioAssessment::class)->latestOfMany('assessed_at');
    }

    public function cvDocuments()
    {
        return $this->belongsToMany(CvDocument::class, 'cv_portfolios');
    }
}
