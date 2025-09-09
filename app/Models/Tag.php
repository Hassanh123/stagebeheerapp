<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['naam'];

   public function stages()
{
    return $this->belongsToMany(Stage::class, 'stage_tag', 'tag_id', 'stage_id');
}

}
