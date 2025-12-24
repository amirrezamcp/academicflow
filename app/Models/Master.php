<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Master extends Model
{
    protected $fillable = [
        'name',
        'graduation',
        'email',
        'phone',
        'specialties',
        'description',
        'status',
    ];

    public function presentations(): HasMany
    {
        return $this->hasMany(Presentation::class);
    }
}
