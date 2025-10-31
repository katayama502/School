<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'unit_id',
        'title',
        'order',
        'material_url',
        'template_code',
    ];

    protected $casts = [
        'template_code' => 'string',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
