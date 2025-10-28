<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    use HasFactory;

    protected $primaryKey = 'course_id';

    protected $fillable = [
        'name',
        'description',
        'stage_id',    // FK naar Stage
        'teacher_id',  // FK naar Teacher (optioneel)
    ];

    /**
     * Course behoort tot een Stage
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

  

}
