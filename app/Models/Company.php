<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    // Velden die mass assignable zijn
    protected $fillable = [
        'naam',
        'adres',
        'contactpersoon',
        'email',
        'telefoon',
    ];

    /**
     * Relatie: een company kan meerdere stages hebben
     */
    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }
}
