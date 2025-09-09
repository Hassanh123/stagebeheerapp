<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    // Voeg hier alle kolommen toe die je via Form of Seeder wilt mass assignen
    protected $fillable = [
        'titel',
        'beschrijving',
        'status',
        'company_id',
        'teacher_id',
    ];

    // Relatie: stage hoort bij een company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relatie: stage hoort bij een teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Optioneel: relatie naar studenten
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
