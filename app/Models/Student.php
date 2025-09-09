<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'naam',
        'email',
        'student_number',
        'stage_id',
    ];

    /**
     * Relatie: student kan één stage hebben
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }
}
