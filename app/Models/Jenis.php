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
}
