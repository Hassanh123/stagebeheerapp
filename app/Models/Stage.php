<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stage extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'titel',
        'beschrijving',
        'status',       // bv. 'vrij' of 'op slot'
        'company_id',
        'teacher_id',
    ];

    /**
     * Relatie: stage hoort bij een bedrijf
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relatie: stage hoort bij een docent
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Relatie: stage heeft meerdere studenten
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Relatie: stage heeft meerdere tags (many-to-many)
     */
   public function tags()
{
    return $this->belongsToMany(Tag::class, 'stage_tag', 'stage_id', 'tag_id');
}

}
