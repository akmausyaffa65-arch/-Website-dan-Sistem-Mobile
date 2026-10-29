<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mahasiswa extends Model
{
    protected $fillable = [
        'nim',
        'nama',
        'program_studi_id',
        'email',
        'nomor_hp',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'golongan_darah',
    ];

    protected $casts = [
        'jenis_kelamin' => 'boolean',
        'tanggal_lahir' => 'date',
    ];

    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(
            ProgramStudi::class,
            'program_studi_id'
        );
    }
}