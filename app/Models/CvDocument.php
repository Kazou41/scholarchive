<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvDocument extends Model
{
    protected $fillable = [
        'student_id',
        'template_name',
        'ai_summary',
        'pdf_path',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class, 'cv_portfolios');
    }
}
