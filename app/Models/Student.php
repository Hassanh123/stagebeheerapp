<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'naam',
        'email',
        'stage_id',
    ];

    /**
     * Relatie: een student hoort bij één stage
     */
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
