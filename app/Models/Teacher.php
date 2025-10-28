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

 
    
}
