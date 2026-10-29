<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pangkat extends Model
{
    protected $fillable = [
        'pangkat',
    ];

    public function dosens(): HasMany
    {
        return $this->hasMany(Dosen::class);
    }
}