<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'name',
        'graduation',
    ];

    public function selections(): HasMany
    {
        return $this->hasMany(Selection::class);
    }

    public function presentations(): BelongsToMany
    {
        return $this->belongsToMany(Presentation::class, 'selections')
                    ->withPivot(['score', 'year_education'])
                    ->withTimestamps();
    }
}
