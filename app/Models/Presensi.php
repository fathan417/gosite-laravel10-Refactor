<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
        'event_id',
        'nama',
        'instansi',
        'province_id',
        'regency_id',
        'signature',
    ];

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relasi ke Province (opsional)
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    // Relasi ke Regency (opsional)
    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regency_id', 'id');
    }
}
