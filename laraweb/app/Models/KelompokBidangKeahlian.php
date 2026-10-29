<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KelompokBidangKeahlian extends Model
{
    protected $fillable = [
        'kelompok_bidang_keahlian',
    ];

    public function dosens(): HasMany
    {
        return $this->hasMany(Dosen::class);
    }
}