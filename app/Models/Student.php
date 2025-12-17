<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
    
    protected function gpa(): Attribute
    {
        return Attribute::make(
            get: function () {

                $selections = $this->selections()
                    ->whereNotNull('score')
                    ->with('presentation.lesson')
                    ->get();

                if ($selections->isEmpty()) {
                    return null;
                }

                $totalWeightedScore = 0;
                $totalUnits = 0;

                foreach ($selections as $selection) {
                    $unit = $selection->presentation->lesson->unit;
                    $score = $selection->score;

                    $totalWeightedScore += $score * $unit;
                    $totalUnits += $unit;
                }

                return round($totalWeightedScore / $totalUnits, 2);
            }
        );
    }
}
