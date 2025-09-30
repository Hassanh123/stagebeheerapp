<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stage extends Model
{
    protected $fillable = [
        'titel',
        'beschrijving',
        'status',
        'company_id',
        'teacher_id',
        'student_id',
    ];

    // Stage belongs to a company
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // Stage belongs to a teacher
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    // Stage has many students
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    // Stage has many-to-many tags
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'stage_tag', 'stage_id', 'tag_id');
    }

    // Stage has many courses
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
