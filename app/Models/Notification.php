<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'notification_id'; // correcte primaire sleutel
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['user_id', 'stage_id', 'status', 'message', 'read_at'];

    // Relatie naar stage
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    // Accessor voor actuele status van de stage
    public function getCurrentStatusAttribute()
    {
        return $this->stage?->status ?? $this->status;
    }
}
