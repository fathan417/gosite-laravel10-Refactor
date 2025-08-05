<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Province;

class Regency extends Model
{
    protected $table = 'regencies';

    public $timestamps = false;

    protected $fillable = ['province_id', 'name'];
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

}
