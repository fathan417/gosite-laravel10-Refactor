<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Jenis extends Model
{
    protected $table = 'jenis';

    protected $fillable = [
        'nama',
    ];

    public function rapat(): BelongsToMany
    {
        return $this->belongsToMany(Rapat::class, 'jenis_rapat', 'jenis_id', 'rapat_id');
    }
}
