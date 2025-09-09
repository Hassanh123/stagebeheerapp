<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'naam',
        'email',
        'student_number',
        'photo_url',
    ];

    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }
}
