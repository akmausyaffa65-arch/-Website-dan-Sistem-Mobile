<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramStudi extends Model
{
    protected $fillable = [
        'program_studi',
    ];

    public function mahasiswas(): HasMany
    {
        return $this->hasMany(Mahasiswa::class);
    }
}