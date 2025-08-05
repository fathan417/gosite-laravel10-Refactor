<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RapatUndanganInternal extends Model
{
    protected $table = 'rapat_undangan_internal';

    protected $fillable = [
        'id_pegawai',
        'id_tamu',
        'rapat_id',
        'telp',
        'role',
        'asal',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'asal' => 'integer',
    ];

    public function rapat(): BelongsTo
    {
        return $this->belongsTo(Rapat::class, 'rapat_id');
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function tamu(): BelongsTo
    {
        return $this->belongsTo(DlsTamu::class, 'id_tamu');
    }

        public function getPesertaAttribute()
    {
        return $this->asal === 2 ? $this->pegawai : $this->tamu;
    }

}
