<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function getPesertaAttribute()
    {
        if ($this->asal === 2) {
            return DB::table('pegawai')->where('id', $this->id_pegawai)->first();
        } else {
            return DB::table('dls_tamu')->where('id', $this->id_tamu)->first();
        }
    }
}
