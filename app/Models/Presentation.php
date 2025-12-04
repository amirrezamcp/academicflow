<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Presentation extends Model
{
    protected $fillable = [
        'master_id',
        'lesson_id',
        'day_hold',
        'start_time',
        'finish_time',
    ];

    public function master(): BelongsTo
    {
        return $this->belongsTo(Master::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function selections(): HasMany
    {
        return $this->hasMany(Selection::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'selections')
                    ->withPivot(['score', 'year_education'])
                    ->withTimestamps();
    }
}
