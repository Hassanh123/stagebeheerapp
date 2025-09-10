<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $fillable = [
        'naam',
        'email',
        'student_number',
        'photo_url',
        'stage_id', // important to link chosen stage
    ];

    // Each student can choose one stage
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }
}
