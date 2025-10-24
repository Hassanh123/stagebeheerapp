<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Model
{
    protected $fillable = [
        'naam',
        'email',
        'user_id',
    ];

    /**
     * Relatie: een teacher hoort bij één gebruiker
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relatie: een teacher kan meerdere stages begeleiden
     */
    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class, 'teacher_id');
    }

    /**
     * Relatie: een teacher heeft meerdere studenten via stages
     */
    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            Stage::class,
            'teacher_id',  // foreign key in stages
            'stage_id',    // foreign key in students
            'id',          // local key in teachers
            'id'           // local key in stages
        );
    }
}
