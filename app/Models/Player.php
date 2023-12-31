<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'position'
    ];

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }
}
