<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'student_id',
        'name',
        'level',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
