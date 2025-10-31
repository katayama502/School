<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class StudentBadge extends Pivot
{
    protected $table = 'student_badges';
    protected $fillable = [
        'student_id',
        'badge_id',
        'awarded_at',
    ];

    protected $casts = [
        'awarded_at' => 'datetime',
    ];
}
