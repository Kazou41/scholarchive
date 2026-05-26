<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioAssessment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'portfolio_id',
        'admin_id',
        'score',
        'feedback',
        'assessed_at',
    ];

    protected $casts = [
        'score' => 'integer',
        'assessed_at' => 'datetime',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
