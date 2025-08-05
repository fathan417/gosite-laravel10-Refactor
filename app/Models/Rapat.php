<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Rapat extends Model
{
    protected $table = 'rapat';

    protected $fillable = [
        'judul',
        'pj_id',
        'waktu_mulai',
        'waktu_selesai',
        'tempat',
        'kak',
        'satker_id',
        'created_by',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($rapat) {
            if (empty($rapat->token_link)) {
                do {
                    $token = Str::random(10);
                } while (self::where('token_link', $token)->exists());

                $rapat->token_link = $token;
            }
        });
    }

    public function jenis(): BelongsToMany
    {
        return $this->belongsToMany(Jenis::class, 'jenis_rapat', 'rapat_id', 'jenis_id');
    }

    public function undangan(): HasMany
    {
        return $this->hasMany(RapatUndanganInternal::class, 'rapat_id');
    }

    public function contents(): HasMany
    {
        return $this->hasMany(EventSiteContent::class, 'rapat_id');
    }

    public function undanganPegawai(): HasMany
    {
        return $this->hasMany(RapatUndanganInternal::class, 'rapat_id')
                    ->where('asal', 2);
    }

    public function undanganTamu(): HasMany
    {
        return $this->hasMany(RapatUndanganInternal::class, 'rapat_id')
                    ->where('asal', 1);
    }


    public function getTahunAttribute(): string
    {
        return $this->waktu_mulai->format('Y');
    }

    public function getBulanAttribute(): string
    {
        return $this->waktu_mulai->format('m');
    }

    public function getJenisNamaAttribute(): array
    {
        return $this->jenis->pluck('nama')->toArray();
    }

    public function scopeFilteredByRequest($query)
    {
        $keyword = trim(strtolower(request('search')));
        $kategori = request('kategori', []);
        $tahun = request('tahun', []);
        $bulan = request('bulan', []);
    
        if (!is_array($kategori)) $kategori = explode(',', $kategori);
        if (!is_array($tahun)) $tahun = explode(',', $tahun);
        if (!is_array($bulan)) $bulan = explode(',', $bulan);
    
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->whereRaw('LOWER(judul) LIKE ?', ["%{$keyword}%"]);
            });
        }
    
        if (!empty(array_filter($kategori))) {
            $query->whereHas('jenis', function ($q) use ($kategori) {
                $q->whereIn('nama', $kategori);
            });
        }
    
        if (!empty(array_filter($tahun))) {
            $query->where(function ($q) use ($tahun) {
                foreach ($tahun as $t) {
                    $q->orWhereYear('waktu_mulai', $t);
                }
            });
        }
    
        if (!empty(array_filter($bulan))) {
            $bulanMap = [
                'januari' => '01', 'februari' => '02', 'maret' => '03', 'april' => '04',
                'mei' => '05', 'juni' => '06', 'juli' => '07', 'agustus' => '08',
                'september' => '09', 'oktober' => '10', 'november' => '11', 'desember' => '12'
            ];
        
            $bulanAngka = array_map(function ($b) use ($bulanMap) {
                return $bulanMap[strtolower($b)] ?? $b;
            }, $bulan);
        
            $query->where(function ($q) use ($bulanAngka) {
                foreach ($bulanAngka as $b) {
                    $q->orWhereMonth('waktu_mulai', $b);
                }
            });
        }
    
        return $query->with(['jenis', 'contents']);
    }

    public function scopeFilteredByPeserta($query, $asal, $id)
    {
        $field = $asal == '2' ? 'id_pegawai' : 'id_tamu';
    
        return $query->whereHas('undangan', function ($q) use ($asal, $field, $id) {
            $q->where('asal', $asal)
              ->where($field, $id);
        });
    }


}
