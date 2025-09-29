<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    protected $fillable = [
        'user_id',        // ✅ voeg user_id toe
        'naam',
        'email',
        'student_number',
        'photo_url',
        'stage_id',
    ];

    // Relatie naar Stage
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    // Relatie naar User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
