<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\RapatUndanganInternal;

class Pegawai extends Model
{
    use SoftDeletes;

    protected $table = 'pegawai';

    protected $fillable = [
        'nip', 'nip_lama', 'nama', 'gelar_depan', 'gelar_belakang',
        'tgl_lahir', 'tmp_lahir', 'jk', 'agama',
        'tmt_cpns', 'tmt_pns', 'status', 'pangkat_id',
        'jabatan_id', 'unitorg_id', 'satker_id',
        'ppk', 'kpa', 'created_by', 'updated_by', 'deleted_by'
    ];

    protected $dates = ['tgl_lahir', 'tmt_cpns', 'tmt_pns'];

    public function user()
    {
        return $this->hasOne(User::class, 'pegawai_id', 'id');
    }

    public function undangan()
    {
        return $this->hasMany(RapatUndanganInternal::class, 'id_pegawai', 'id');
    }

    public function getNamaLengkapAttribute()
    {
        $gelarDepan = trim($this->gelar_depan);
        $gelarBelakang = trim($this->gelar_belakang);
        $nama = trim($this->nama);

        return trim("{$gelarDepan} {$nama} {$gelarBelakang}");
    }
}
