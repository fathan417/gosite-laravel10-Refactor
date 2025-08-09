<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rapat;
use App\Models\Jenis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Services\UserInfoService;
use Illuminate\Pagination\LengthAwarePaginator;




class GositeController extends Controller
{
    private function userInfo($email){
        $profil = [];

        if ($email){ 
            $asal = "2";
            $id_peserta = DB::table('users')->select('pegawai_id')->where('email','=',$email)->get();
            $profil = DB::table('pegawai')->select('id','jk','nama')->where('id','=',$id_peserta[0]->pegawai_id)->get();
            $profil[0]->instansi = 'Badan Pusat Statistik';
            $profil[0]->pekerjaan = 'PNS';
            $profil[0]->nohp = '-';
            $profil[0]->alamat = '-'; 
            $profil[0]->asal = "2";
        } else {
            $asal = "1";
            $id_peserta = DB::table('dls_tamu')->select('id')->where('email','=',$email)->get();
            $profil = DB::table('dls_tamu')->select('id','email','nama','nohp','pekerjaan','instansi','alamat','jk')->where('id_tamu','=',$id_peserta[0]->id)->get();
            $profil[0]->asal = "1";
        }

        $profil[0]->email = $email;
        return $profil;
    }

 public function index(Request $request)
{
    if (!Auth::check()) {
        return redirect()->intended('/logins');
    }

    $email = Auth::user()->email;
    $profil = $this->userInfo($email);
    $asal = $profil[0]->asal;
    $idUser = $profil[0]->id;

    $keyword = trim($request->get('search', ''));
    $kategoriFilter = $request->get('kategori', []);
    $tahunFilter = $request->get('tahun', []);
    $bulanFilter = $request->get('bulan', []);

    $kategoriFilter = is_array($kategoriFilter) ? $kategoriFilter : explode(',', $kategoriFilter);
    $tahunFilter = is_array($tahunFilter) ? $tahunFilter : explode(',', $tahunFilter);
    $bulanFilter = is_array($bulanFilter) ? $bulanFilter : explode(',', $bulanFilter);

    $query = DB::table('rapat')
        ->join('rapat_undangan_internal', function ($join) use ($asal, $idUser) {
            $join->on('rapat.id', '=', 'rapat_undangan_internal.rapat_id')
                ->where('rapat_undangan_internal.asal', $asal);

            if ($asal == '2') {
                $join->where('rapat_undangan_internal.id_pegawai', $idUser);
            } else {
                $join->where('rapat_undangan_internal.id_tamu', $idUser);
            }
        })
        ->select('rapat.*', 'rapat_undangan_internal.role');

    if ($keyword !== '') {
        $query->where('rapat.judul', 'like', '%' . $keyword . '%');
    }

    if (!empty($kategoriFilter)) {
        $query->join('jenis_rapat', 'rapat.id', '=', 'jenis_rapat.rapat_id')
            ->join('jenis', 'jenis_rapat.jenis_id', '=', 'jenis.id')
            ->whereIn('jenis.nama', $kategoriFilter)
            ->distinct('rapat.id');
    }

    if (!empty(array_filter($tahunFilter))) {
        $query->whereIn(DB::raw('YEAR(rapat.waktu_mulai)'), $tahunFilter);
    }

    if (!empty(array_filter($bulanFilter))) {
        $bulanMap = [
            'januari' => '01', 'februari' => '02', 'maret' => '03', 'april' => '04',
            'mei' => '05', 'juni' => '06', 'juli' => '07', 'agustus' => '08',
            'september' => '09', 'oktober' => '10', 'november' => '11', 'desember' => '12'
        ];
        $bulanAngka = array_map(function ($b) use ($bulanMap) {
            return $bulanMap[strtolower($b)] ?? $b;
        }, $bulanFilter);

        $query->whereIn(DB::raw('MONTH(rapat.waktu_mulai)'), $bulanAngka);
    }

    $perPage = 6;
    $paginated = $query->select('rapat.*', 'rapat_undangan_internal.role')
        ->distinct()
        ->paginate($perPage)
        ->withQueryString();

    $rapatIds = $paginated->pluck('id')->toArray();

    $allContents = DB::table('event_site_contents')
        ->whereIn('rapat_id', $rapatIds)
        ->get()
        ->groupBy('rapat_id');

    $allJenisRapat = DB::table('jenis_rapat')
        ->join('jenis', 'jenis_rapat.jenis_id', '=', 'jenis.id')
        ->whereIn('jenis_rapat.rapat_id', $rapatIds)
        ->select('jenis_rapat.rapat_id', 'jenis.nama')
        ->get()
        ->groupBy('rapat_id');

    foreach ($paginated as $rapat) {
        $rapatContents = $allContents->has($rapat->id) ? $allContents[$rapat->id] : collect();
        $jenisList = $allJenisRapat->has($rapat->id) ? $allJenisRapat[$rapat->id]->pluck('nama')->toArray() : [];
        $rapat->jenis_nama = $jenisList;

        foreach ($rapatContents as $content) {
            $content->linkstat = ($content->role == 2 && $rapat->role == 1) ? 'hide' : 'show';
        }

        $rapat->contents = $rapatContents;
    }

    $peserta = DB::table('rapat_undangan_internal')
        ->where('asal', $asal)
        ->when($asal == '2', fn ($q) => $q->where('id_pegawai', $idUser), fn ($q) => $q->where('id_tamu', $idUser))
        ->get();

    $allJenis = \App\Models\Jenis::pluck('nama')->unique()->toArray();
    $allTahun = range(2015, now()->year);
    $allBulan = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $logoLight = asset('images/gosite/logo-prov-gto.png');
    $logoDark = asset('images/gosite/logo-prov-gto-white.png');

    if ($request->ajax()) {
        return response()->json([
            'html' => view('partials.cards', ['paginated' => $paginated])->render()
        ]);
    }

    return view('gosite', compact(
        'paginated',
        'keyword',
        'peserta',
        'profil',
        'logoLight',
        'logoDark',
        'allJenis',
        'allTahun',
        'allBulan'
    ));
}

    public function searchPublicEvents(Request $request)
{
    if (!Auth::check()) {
        return redirect()->intended('/logins');
    }

    $email = Auth::user()->email;
    $profil = $this->userInfo($email);
    $asal = $profil[0]->asal;
    $idUser = $profil[0]->id;

    $keyword = trim($request->get('search', ''));
    $kategoriFilter = $request->get('kategori', []);
    $tahunFilter = $request->get('tahun', []);
    $bulanFilter = $request->get('bulan', []);

    $kategoriFilter = is_array($kategoriFilter) ? $kategoriFilter : explode(',', $kategoriFilter);
    $tahunFilter = is_array($tahunFilter) ? $tahunFilter : explode(',', $tahunFilter);
    $bulanFilter = is_array($bulanFilter) ? $bulanFilter : explode(',', $bulanFilter);

    $query = DB::table('rapat')
        ->join('rapat_undangan_internal', function($join) use ($asal, $idUser) {
            $join->on('rapat.id', '=', 'rapat_undangan_internal.rapat_id')
                 ->where('rapat_undangan_internal.asal', $asal);

            if ($asal == '2') {
                $join->where('rapat_undangan_internal.id_pegawai', $idUser);
            } else {
                $join->where('rapat_undangan_internal.id_tamu', $idUser);
            }
        })
        ->select('rapat.*', 'rapat_undangan_internal.role');

    if ($keyword !== '') {
        $query->where('rapat.judul', 'like', '%' . $keyword . '%');
    }

    if (!empty($kategoriFilter)) {
        $query->join('jenis_rapat', 'rapat.id', '=', 'jenis_rapat.rapat_id')
              ->join('jenis', 'jenis_rapat.jenis_id', '=', 'jenis.id')
              ->whereIn('jenis.nama', $kategoriFilter)
              ->distinct('rapat.id');
    }

    if (!empty(array_filter($tahunFilter))) {
        $query->whereIn(DB::raw('YEAR(rapat.waktu_mulai)'), $tahunFilter);
    }

    if (!empty(array_filter($bulanFilter))) {
        $bulanMap = [
            'januari' => '01', 'februari' => '02', 'maret' => '03', 'april' => '04',
            'mei' => '05', 'juni' => '06', 'juli' => '07', 'agustus' => '08',
            'september' => '09', 'oktober' => '10', 'november' => '11', 'desember' => '12'
        ];
        $bulanAngka = array_map(function ($b) use ($bulanMap) {
            return $bulanMap[strtolower($b)] ?? $b;
        }, $bulanFilter);

        $query->whereIn(DB::raw('MONTH(rapat.waktu_mulai)'), $bulanAngka);
    }

    $perPage = 6;
    $paginated = $query->select('rapat.*', 'rapat_undangan_internal.role')
                      ->distinct()
                      ->paginate($perPage)
                      ->withQueryString();

    $rapatIds = $paginated->pluck('id')->toArray();
    $allContents = DB::table('event_site_contents')
        ->whereIn('rapat_id', $rapatIds)
        ->get()
        ->groupBy('rapat_id');

    $allJenisRapat = DB::table('jenis_rapat')
        ->join('jenis', 'jenis_rapat.jenis_id', '=', 'jenis.id')
        ->whereIn('jenis_rapat.rapat_id', $rapatIds)
        ->select('jenis_rapat.rapat_id', 'jenis.nama')
        ->get()
        ->groupBy('rapat_id');

    foreach ($paginated as $rapat) {
        $rapatContents = $allContents->has($rapat->id) ? $allContents[$rapat->id] : collect();
        $jenisList = $allJenisRapat->has($rapat->id) ? $allJenisRapat[$rapat->id]->pluck('nama')->toArray() : [];
        $rapat->jenis_nama = $jenisList;

        foreach ($rapatContents as $content) {
            $content->linkstat = ($content->role == 2 && $rapat->role == 1) ? 'hide' : 'show';
        }

        $rapat->contents = $rapatContents;
    }

    $peserta = DB::table('rapat_undangan_internal')
        ->where('asal', $asal)
        ->when($asal == '2', fn($q) => $q->where('id_pegawai', $idUser), fn($q) => $q->where('id_tamu', $idUser))
        ->get();

    $allJenis = \App\Models\Jenis::pluck('nama')->unique()->toArray();
    $allTahun = range(2015, now()->year);
    $allBulan = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $logoLight = asset('images/gosite/logo-prov-gto.png');
    $logoDark = asset('images/gosite/logo-prov-gto-white.png');

    if ($request->ajax()) {
        return response()->json([
            'html' => view('partials.cards', compact(
                'paginated',
                'keyword',
                'peserta',
                'profil',
                'logoLight',
                'logoDark',
                'allJenis',
                'allTahun',
                'allBulan'
            ))->render()
        ]);
    }

    return view('gosite', compact(
        'paginated',
        'keyword',
        'peserta',
        'profil',
        'logoLight',
        'logoDark',
        'allJenis',
        'allTahun',
        'allBulan'
    ));
}


}
