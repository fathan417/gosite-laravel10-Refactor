<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class RegistrationController extends Controller{

    public function index(){
        
        $instansi = DB::table('instansi')
        ->select('id','nama')
        ->get();

        // dd($instansi);

        return view('registration', [
            "instansi" => $instansi
        ]);
    }

    public function submitRegist(Request $request)
    {

        $cek = DB::table('dls_tamu')->where('email','=',$request->input('email'))->get();

        if(count($cek) != 0){
            print_r('Email Sudah Terdaftar. Mohon login menggunakan Google Auth.');
        } else {
            DB::table('dls_tamu')->insert([
               'sapaan' => $request->input('sapaan'),
               'nama' => $request->input('nama'),
               'jk' => $request->input('jk'),
               'instansi_id' => (int)($request->input('instansi_id')),
               'instansi' => $request->input('instansi'),
               'email' => $request->input('email'),
               'nohp' => $request->input('telepon'),
               'pekerjaan' => $request->input('pekerjaan'),
               'alamat' => $request->input('alamat'),
               'password' => bcrypt('12345678'),
               'confirm_nohp' => 1,
               'confirm_email' => 1,
               'bcwa' => 1,
               'bcemail' => 1,
               'created_at' => now(),
               'updated_at' => now()

            ]);
            return('Sukses melakukan pendaftaran. Silahkan login menggunakan Google Auth.');
        }
  
    }


}
