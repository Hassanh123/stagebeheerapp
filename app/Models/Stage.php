<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// ✅ Add these imports
use App\Models\Company;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Tag;

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

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'stage_tag', 'stage_id', 'tag_id');
    }
}
