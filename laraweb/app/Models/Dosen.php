<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dosen extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nidn',
        'nip',
        'tmt',
        'nama_lengkap',
        'pangkat_id',
        'jenis_kelamin',
        'foto',
        'kelompok_bidang_keahlian_id',
        'bidang_keilmuan',
        'fungsi_fungsional',
        'status',
        'user_id',
        'program_studi_id',
    ];

    protected $casts = [
        'tmt' => 'date',
        'jenis_kelamin' => 'boolean',
    ];

    public function pangkat(): BelongsTo
    {
        return $this->belongsTo(Pangkat::class);
    }

    public function kelompokBidangKeahlian(): BelongsTo
    {
        return $this->belongsTo(
            KelompokBidangKeahlian::class,
            'kelompok_bidang_keahlian_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(
            ProgramStudi::class,
            'program_studi_id'
        );
    }
}