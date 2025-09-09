<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;


    public $incrementing = true;          // als student_id auto_increment is
    protected $keyType = 'int';

    protected $fillable = [
        'naam',
        'email',
        'stage_id',
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
