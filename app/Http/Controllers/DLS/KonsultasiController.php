<?php

namespace App\Http\Controllers\DLS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class KonsultasiController extends Controller
{
    public function index(){
        return view('diseminasi.frontend.konsultasi.index');
    }
    public function register(){
        return view('diseminasi.frontend.konsultasi.register');
    }
    public function registerKSL(){
        return view('diseminasi.frontend.konsultasi.registerKSL');
    }
    
    public function registerSave(Request $request){
        $rules = [
            'nama'=>'required|max:255',
            'email'=>'required|email|max:64',
            'nohp'=>'required|numeric',
            'tgl_konsultasi'=>'required|date|date_format:d-m-Y',
            'waktu_konsultasi'=>'required',
            'uraian'=>'required|max:128',
            'captcha' => 'required|captcha'
        ];
        $attr = [
            'nama'=>'Nama',
            'email'=>'Email',
            'nohp'=>'Nomor HP',
            'tgl_konsultasi'=>'Tanggal Konsultasi',
            'waktu_konsultasi'=>'Waktu Konsultasi',
            'uraian'=>'Uraian Konsultasi',
            'captcha'=>'Captcha'
        ];
        $validator = \Validator::make($request->all(), $rules)->setAttributeNames($attr);
        if ($validator->fails()) {
            return redirect(asset(route('diseminasi.konsultasi.register', [], false)))->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try{
            $tamu = \App\Tamu::updateOrCreate(['nohp'=>$request->nohp, 'email'=>$request->email],[
                'sapaan'=>$request->sapaan,
                'nama'=>$request->nama,
                'nohp'=>$request->nohp,
                'email'=>$request->email
                ]);
                
            $kunj = \App\Kunjungan::create([
                'is_consult'=>1,
                'keperluan'=>$request->uraian,
                'tamu_id'=>$tamu->id,
                'is_ppd' =>0,
                'is_online' =>1
            ]);
            $konsult = \App\Konsultasi::create([
                'tgl_konsultasi'=>fdate($request->tgl_konsultasi, 'Y-m-d'),
                'waktu_konsultasi'=>$request->waktu_konsultasi,
                'uraian'=>$request->uraian,
                'tamu_id'=>$tamu->id,
                'token'=>\Str::random(64),
                'metode'=>1
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
        \Mail::to($tamu->email)
        ->bcc(['assel@bps.go.id', 'nurain.ibrahim@bps.go.id', 'ipds7500@bps.go.id', 'pst7500@bps.go.id','choirunisakm@bps.go.id','sigit.putra@bps.go.id','nicken.worosasi@bps.go.id'])
        ->send(new \App\Mail\KonsultasiMail($konsult));
      
        return redirect()->route('diseminasi.konsultasi.register.response')->with('status', 'terdaftar');

    }
    public function registerResponse(Request $request){
        if (\Session::get('status')){
            if(\Session::get('status')=='belum_mulai'){
                $konsultasi = \App\Konsultasi::where('token', $request->token)->first();
                return view('diseminasi.frontend.konsultasi.belum_mulai', compact('konsultasi'));
            }else if(\Session::get('status')=='kadaluarsa'){
                $konsultasi = \App\Konsultasi::where('token', $request->token)->first();
                return view('diseminasi.frontend.konsultasi.kadaluarsa', compact('konsultasi'));
            }else if(\Session::get('status')=='terdaftar'){
                return view('diseminasi.frontend.konsultasi.register_response');
            }
        }else{
            return redirect(asset(route('diseminasi.konsultasi.register', [], false)));
        }
    }
    public function joinMeeting(Request $request, $token){
        $konsultasi = \App\Konsultasi::where('token', $token)->first();
        // $now = Carbon::now();
        $waktu = \Carbon\Carbon::parse($konsultasi->tgl_konsultasi.' '.$konsultasi->waktu_konsultasi)->floatDiffInMinutes(date('Y-m-d H:i:s'), false);
        if($waktu<0){
            return redirect(asset(route('diseminasi.konsultasi.register.respons', ['token'=>$token], false)))
            ->with('status', 'belum_mulai');
        }else if($waktu>60){
            return redirect(asset(route('diseminasi.konsultasi.register.respons', ['token'=>$token], false)))
            ->with('status', 'kadaluarsa');
        }
        
        if($konsultasi!=null){
            $meeting_link = $konsultasi->meeting_link??setting('meeting_link');
            return redirect($meeting_link);
        }else{
            abort(404);
        }
    }

    public function registerKSLSave(Request $request){
        $rules = [
            'nama'=>'required|max:255',
            'email'=>'required|email|max:64',
            'nohp'=>'required|numeric',
            'tgl_konsultasi'=>'required|date|date_format:d-m-Y',
            'waktu_konsultasi'=>'required',
            'uraian'=>'required|max:128',
            'captcha' => 'required|captcha'
        ];
        $attr = [
            'nama'=>'Nama',
            'email'=>'Email',
            'nohp'=>'Nomor HP',
            'tgl_konsultasi'=>'Tanggal Konsultasi',
            'waktu_konsultasi'=>'Waktu Konsultasi',
            'uraian'=>'Uraian Konsultasi',
            'captcha'=>'Captcha'
        ];
        $validator = \Validator::make($request->all(), $rules)->setAttributeNames($attr);
        if ($validator->fails()) {
            return redirect(asset(route('diseminasi.konsultasi.registerKSL', [], false)))->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try{
            $tamu = \App\Tamu::updateOrCreate(['nohp'=>$request->nohp, 'email'=>$request->email],[
                'sapaan'=>$request->sapaan,
                'nama'=>$request->nama,
                'nohp'=>$request->nohp,
                'email'=>$request->email
                ]);
                
            $kunj = \App\Kunjungan::create([
                'is_consult'=>1,
                'keperluan'=>$request->uraian,
                'tamu_id'=>$tamu->id,
                'is_ppd' =>0,
                'is_online' =>0
            ]);
            $konsult = \App\Konsultasi::insertGetId([
                'tgl_konsultasi'=>fdate($request->tgl_konsultasi, 'Y-m-d'),
                'waktu_konsultasi'=>$request->waktu_konsultasi,
                'uraian'=>$request->uraian,
                'tamu_id'=>$tamu->id,
                'token'=>\Str::random(64),
                'metode'=>2,
                'created_at'=>\Carbon\Carbon::now()
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
        // \Mail::to($tamu->email)
        // ->bcc(['nicken.worosasi@bps.go.id'])
        // ->send(new \App\Mail\KonsultasiMail($konsult));

        $this->registerKSLWAResponse($konsult);
        // $this->KSLGroupNotif($konsult);

        return redirect(asset(route('diseminasi.konsultasi.registerKSL.response', [],false)))->with('status', 'terdaftar');
    }

    public function registerKSLResponse(Request $request){
        if (\Session::get('status')){
            if(\Session::get('status')=='terdaftar'){
                return view('diseminasi.frontend.konsultasi.registerKSL_response');
            }
        }else{
            return redirect(asset(route('diseminasi.konsultasi.registerKSL', [], false)));
        }
    }

    public function registerKSLWAResponse($id){

        // dd($id);
        $konsultasi = DB::table('dls_konsultasi')->where('id', $id)->get();
        $tamu = DB::table('dls_tamu')
                ->where('id', $konsultasi[0]->tamu_id)
                ->select('nama','nohp')
                ->get();

        $curl = curl_init();
        $token = "MeGngd3vwSR7Sol3iE8xcvMvCvToQ0wyIm5K7ezo0OLxatlAR9Nfmfp";
        $secret_key = "6AUykICp";
        $data = [
        'phone' => $tamu[0]->nohp,
        'message' => 'Halo '.$tamu[0]->nama.
        ', Anda telah membuat janji Konsultasi Langsung'.
        ' di BPS Provinsi Gorontalo pada tanggal '.$konsultasi[0]->tgl_konsultasi.
        ' pukul '.$konsultasi[0]->waktu_konsultasi.' WITA dengan topik '.$konsultasi[0]->uraian.'. Mohon konfirmasi kehadiran anda 1 hari sebelum jadwal konsultasi. Terima kasih.',
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token.$secret_key",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL,  "https://pati.wablas.com/api/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        // echo "<pre>";
        // print_r($result);
    }

    public function KSLGroupNotif($id){

        $konsultasi = DB::table('dls_konsultasi')->where('id', $id)->get();
        $tamu = DB::table('dls_tamu')
                ->where('id', $konsultasi[0]->tamu_id)
                ->select('nama','nohp')
                ->get();

        // $curl = curl_init();
        // $token = "MeGngd3vwSR7Sol3iE8xcvMvCvToQ0wyIm5K7ezo0OLxatlAR9Nfmfp";
        // $secret_key = "6AUykICp";
        // $random = true;
        // $payload = [
        //     "data" => [
        //         [
        //             'phone' => '6285217501988-1561533463',
        //             'message' => '*[TES NOTIF KONSULTASI LANGSUNG]*'.
        //                         ' Hai Gengz, ada pendaftaran konsultasi langsung atas nama '.
        //                         $tamu[0]->nama.' ('.$tamu[0]->nohp.') pada tanggal '.
        //                         $konsultasi[0]->tgl_konsultasi.' pukul '.
        //                         $konsultasi[0]->waktu_konsultasi.' WITA dengan topik '.
        //                         $konsultasi[0]->uraian.'. Jangan sampai lupa. Thx.',
        //             'isGroup' => 'true'
        //         ]
        //     ]
        // ];
        // curl_setopt($curl, CURLOPT_HTTPHEADER,
        //     array(
        //         "Authorization: $token",
        //         "Content-Type: application/json"
        //     )
        // );
        // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload) );
        // curl_setopt($curl, CURLOPT_URL,  "https://pati.wablas.com/api/v2/send-message");
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        // $result = curl_exec($curl);
        // curl_close($curl);
        // echo "<pre>";
        // print_r($result);


        $curl = curl_init();
        $token = "MeGngd3vwSR7Sol3iE8xcvMvCvToQ0wyIm5K7ezo0OLxatlAR9Nfmfp";
        $secret_key = "6AUykICp";
        $payload = [
            "data" => [
                [
                    'group_id' => '6285217501988-1561533463',
                    'message' => '*[TES NOTIF KONSULTASI LANGSUNG]*'.
                                ' Hai Gengz, ada pendaftaran konsultasi langsung atas nama '.
                                $tamu[0]->nama.' ('.$tamu[0]->nohp.') pada tanggal '.
                                $konsultasi[0]->tgl_konsultasi.' pukul '.
                                $konsultasi[0]->waktu_konsultasi.' WITA dengan topik '.
                                $konsultasi[0]->uraian.'. Jangan sampai lupa. Thx.',
                    'isGroup' => 'true'
                ]
            ]
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token.$secret_key",
                "Content-Type: application/json"
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload) );
        curl_setopt($curl, CURLOPT_URL,  "https://pati.wablas.com/api/v2/group/text");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($curl);
        curl_close($curl);
        echo "<pre>";
        print_r($result);
    }
    
}
