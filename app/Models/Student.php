<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class Student extends Model
{
    protected $fillable = [
        'name',
        'graduation',
        'student_number',
        'email',
        'phone',
        'description',
        'status',
    ];

    protected $attributes = [
        'status' => 'active',
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

    public function getStatusAttribute($value)
    {
        if (Schema::hasColumn('students', 'status')) {
            return $value ?? 'active';
        }
        return 'active';
    }

    public function getStatusInPersianAttribute()
    {
        return match($this->status) {
            'active' => 'فعال',
            'inactive' => 'غیرفعال',
            'graduated' => 'فارغ التحصیل',
            default => 'نامشخص'
        };
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
                    $unit = $selection->presentation->lesson->unit ?? 0;
                    $score = $selection->score ?? 0;

                    $totalWeightedScore += $score * $unit;
                    $totalUnits += $unit;
                }

                return $totalUnits > 0 ? round($totalWeightedScore / $totalUnits, 2) : 0;
            }
        );
    }

    public function getSelectionsCountAttribute()
    {
        return $this->selections()->count();
    }
}
