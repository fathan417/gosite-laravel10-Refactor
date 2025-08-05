<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Regency;

class Province extends Model
{
    protected $table = 'provinces';

    public $timestamps = false;
    public function regencies()
    {
        return $this->hasMany(Regency::class);
    }

}
