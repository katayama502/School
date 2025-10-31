<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Progress extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'progress';

    protected $fillable = [
        'student_id',
        'lesson_id',
        'status',
        'percent',
        'last_viewed_at',
    ];

    protected $casts = [
        'percent' => 'integer',
        'last_viewed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
