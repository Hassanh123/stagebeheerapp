<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    // Velden die mass assignable zijn
    protected $fillable = [
        'naam',
        'email',
    ];

    /**
     * Relatie: een teacher kan meerdere stages begeleiden
     */
    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }
}
