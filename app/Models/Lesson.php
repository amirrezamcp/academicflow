<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = [
        'name',
        'unit',
    ];

    public function presentations(): HasMany
    {
        return $this->hasMany(Presentation::class);
    }
}
