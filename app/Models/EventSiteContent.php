<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventSiteContent extends Model
{
    protected $table = 'event_site_contents';

    protected $fillable = [
        'name',
        'link',
        'role',
        'class',
        'rapat_id',
    ];

    protected $casts = [
        'rapat_id' => 'integer',
    ];

    public function rapat(): BelongsTo
    {
        return $this->belongsTo(Rapat::class, 'rapat_id');
    }

    public function getLinkstatAttribute(): string
    {
        $default = 'hide';

        if (!auth()->check()) return $default;

        $userInfoService = app(\App\Services\UserInfoService::class);
        $profil = $userInfoService->getInfo(auth()->user()->email);
        if (!$profil || !$this->rapat || !$this->rapat->relationLoaded('undangan')) return $default;

        $undangan = $this->rapat->undangan->firstWhere(function ($u) use ($profil) {
            return $u->asal == $profil->asal &&
                ($profil->asal == '2' ? $u->id_pegawai == $profil->id : $u->id_tamu == $profil->id);
        });

        $rolePeserta = optional($undangan)->role;

        return ($this->role == 2 && $rolePeserta == 1) ? 'hide' : 'show';
    }
}
