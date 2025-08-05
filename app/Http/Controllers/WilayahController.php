<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    public function getProvinsi()
    {
        $provinsi = DB::table('provinces')->select('id', 'name')->get();

        return response()->json($provinsi);
    }

    public function getKabupaten($province_id)
    {
        $kabupaten = DB::table('regencies')
            ->where('province_id', $province_id)
            ->select('id', 'name')
            ->get();

        return response()->json($kabupaten);
    }

}
