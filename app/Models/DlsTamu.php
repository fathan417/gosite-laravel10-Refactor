<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DlsTamu extends Model
{
    use HasFactory;

    protected $table = 'dls_tamu';

    protected $fillable = [
        'sapaan', 'nama', 'email', 'nohp', 'pekerjaan', 'instansi',
        'instansi_id', 'kategori_instansi', 'alamat', 'jk', 'usia',
        'token', 'confirm_nohp', 'confirm_email', 'bcwa', 'bcemail',
        'satker_id', 'password', 'created_by', 'updated_by', 'deleted_by'
    ];

    protected $casts = [
        'confirm_nohp' => 'boolean',
        'confirm_email' => 'boolean',
        'bcwa' => 'boolean',
        'bcemail' => 'boolean',
        'satker_id' => 'integer',
    ];
}
