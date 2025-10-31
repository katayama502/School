<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodeRun extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'submission_id',
        'language',
        'source_hash',
        'stdout',
        'stderr',
        'exit_code',
        'cpu_ms',
        'mem_kb',
        'timed_out',
    ];

    protected $casts = [
        'timed_out' => 'boolean',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
