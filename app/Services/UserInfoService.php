<?php

namespace App\Services;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\DlsTamu;

class UserInfoService
{
    protected static ?object $cachedProfile = null;
    protected static ?string $cachedEmail = null;

    public function getInfo(string $email): ?object
    {
        // Cegah query berulang dalam 1 request
        if (self::$cachedEmail === $email && self::$cachedProfile !== null) {
            return self::$cachedProfile;
        }

        $user = User::where('email', $email)->first();

        if ($user && $user->pegawai_id) {
            $pegawai = Pegawai::select('id', 'jk', 'nama')->find($user->pegawai_id);

            if ($pegawai) {
                $pegawai->instansi = 'Badan Pusat Statistik';
                $pegawai->pekerjaan = 'PNS';
                $pegawai->nohp = '-';
                $pegawai->alamat = '-';
                $pegawai->asal = '2';
                $pegawai->email = $email;

                self::$cachedEmail = $email;
                self::$cachedProfile = $pegawai;

                return $pegawai;
            }
        }

        $tamu = DlsTamu::where('email', $email)->first();

        if ($tamu) {
            $tamu->asal = '1';

            self::$cachedEmail = $email;
            self::$cachedProfile = $tamu;

            return $tamu;
        }

        return null;
    }
}
