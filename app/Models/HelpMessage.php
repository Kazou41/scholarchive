<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'status',
    ];
}
