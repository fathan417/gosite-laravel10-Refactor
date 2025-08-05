<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rapat;
use App\Models\Jenis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Services\UserInfoService;




class GositeController extends Controller
{
    public function index(Request $request, UserInfoService $userInfoService)
    {
        if (!Auth::check()) {
            return redirect()->intended('/logins');
        }

        $email = Auth::user()->email;
        $profil = $userInfoService->getInfo($email);

        $paginated = $this->getPaginatedRapat($profil);

        $filterOptions = $this->getFilterOptions();
        $logos = $this->getLogos();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.cards', compact('paginated'))->render()
            ]);
        }

        return view('gosite', array_merge(
            compact('paginated', 'profil'),
            $filterOptions,
            $logos
        ));
    }



    public function newToken(Request $request){

        $token = $request->input('token');
        $id_event = DB::table('rapat')
        ->select('id')
        ->where('token','=',$token)
        ->get();
        
        if(count($id_event) != 0){

            $email = Auth::user()->email; 
            $profil = $this->userInfo($email);
            
            if($profil[0]->asal == 1){

                DB::table('rapat_undangan_internal')->insert([
                    'id_event' => (int)($id_event[0]->id),
                    'id_tamu' => (int)($profil[0]->id),
                    'asal' => (int)($profil[0]->asal),
                    'role' => 1
                ]);
            } else {
                DB::table('rapat_undangan_internal')->insert([
                    'id_event' => (int)($id_event[0]->id),
                    'id_pegawai' => (int)($profil[0]->id),
                    'asal' => (int)($profil[0]->asal),
                    'role' => 1 
                ]); 
                return('Kegiatan baru telah ditambahkan');
            }

            return($profil[0]->id);

        } else {
            return('Token Yang Anda Masukkan Salah');
        }
    }

    public function searchPublicEvents(Request $request, UserInfoService $userInfoService)
    {
        if (!Auth::check()) {
            return redirect()->intended('/logins');
        }

        $email = Auth::user()->email;
        $profil = $userInfoService->getInfo($email);

        $paginated = $this->getPaginatedRapat($profil);

        $filterOptions = $this->getFilterOptions();
        $logos = $this->getLogos();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.cards', compact('paginated'))->render()
            ]);
        }

        return view('gosite', array_merge(
            compact('paginated', 'profil'),
            $filterOptions,
            $logos
        ));
    }

    private function getPaginatedRapat($profil)
    {
        return Rapat::query()
            ->with(['jenis', 'contents.rapat.undangan'])
            ->filteredByPeserta($profil->asal, $profil->id)
            ->filteredByRequest()
            ->orderByDesc('waktu_mulai')
            ->paginate(6);
    }

    private function getFilterOptions()
    {
        return [
            'allJenis' => Cache::remember('jenis_list', 3600, fn () => Jenis::pluck('nama')->unique()->toArray()),
            'allTahun' => Cache::remember('tahun_list', 3600, fn () => range(2015, now()->year)),
            'allBulan' => Cache::rememberForever('bulan_list', fn () => [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ]),
        ];
    }

    private function getLogos()
    {
        return [
            'logoLight' => asset('images/gosite/logo-prov-gto.png'),
            'logoDark' => asset('images/gosite/logo-prov-gto-white.png'),
        ];
    }

}
