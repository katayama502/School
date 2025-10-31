<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'assignment_id',
        'type',
        'status',
        'score',
        'feedback',
        'content_ref',
        'run_stats',
    ];

    protected $casts = [
        'run_stats' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function runs()
    {
        return $this->hasMany(CodeRun::class);
    }
}
