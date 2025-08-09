<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\UserInfoService;

class EventController extends Controller
{
    public function index()
    {
        // Ambil event berdasarkan created_by (hardcode 15, bisa sesuaikan)
        $rapat = DB::table('rapat')
            ->select('id', 'judul', 'waktu_mulai', 'waktu_selesai', 'tempat', 'created_by')
            ->where('created_by', 15)
            ->get();

        return view('event', [
            'sidebar' => 'Event',
            'rapat' => $rapat,
        ]);
    }

    public function addEvent()
    {
        // Ambil data pegawai untuk opsi penanggung jawab
        $pegawai = DB::table('pegawai')->select('id', 'nama')->get();

        return view('dash_events.add', [
            'sidebar' => 'Event',
            'pegawai' => $pegawai,
        ]);
    }

    public function sendEvent(Request $request)
    {
        $validated = $request->validate([
            'namakeg' => 'required|string|max:255',
            'namaket' => 'required|integer|exists:pegawai,id',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'tempat' => 'required|string|max:255',
            'kak' => 'nullable|file|mimes:pdf,docx,doc|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('kak')) {
            $path = $request->file('kak')->store('files/kak');
        }

        // Insert data rapat manual dengan query builder
        DB::table('rapat')->insert([
            'judul' => $validated['namakeg'],
            'pj_id' => $validated['namaket'],
            'waktu_mulai' => $validated['tgl_mulai'],
            'waktu_selesai' => $validated['tgl_selesai'],
            'tempat' => $validated['tempat'],
            'kak' => $path,
            'created_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('event.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function showEvent($id, UserInfoService $userInfoService)
    {
        if (!Auth::check()) {
            return redirect()->intended('/logins');
        }

        $email = Auth::user()->email;
        $profil = $userInfoService->getInfo($email);
        $asal = $profil->asal;
        $idUser = $profil->id;

        // Ambil data rapat
        $rapat = DB::table('rapat')
            ->where('id', $id)
            ->first();

        if (!$rapat) {
            abort(404, 'Event tidak ditemukan');
        }

        // Ambil data undangan sesuai profil user
        $undanganQuery = DB::table('rapat_undangan_internal')
            ->where('rapat_id', $id)
            ->where('asal', $asal);

        if ($asal == '2') {
            $undanganQuery->where('id_pegawai', $idUser);
        } else {
            $undanganQuery->where('id_tamu', $idUser);
        }

        $undangan = $undanganQuery->first();

        // Role user dalam rapat (default 0 jika tidak ada undangan)
        $rapat->role = $undangan?->role ?? 0;

        // Ambil konten rapat
        $contents = DB::table('event_site_contents')
            ->where('rapat_id', $id)
            ->get();

        // Tandai setiap content dengan linkstat = 'show'
        foreach ($contents as $content) {
            $content->linkstat = 'show';
        }

        // Ambil jenis rapat (bisa lebih dari satu)
        $jenis = DB::table('jenis_rapat')
            ->join('jenis', 'jenis_rapat.jenis_id', '=', 'jenis.id')
            ->where('jenis_rapat.rapat_id', $id)
            ->select('jenis.nama')
            ->pluck('nama')
            ->toArray();

        // Inject data tambahan ke objek rapat
        $rapat->contents = $contents;
        $rapat->jenis_nama = $jenis;
        $rapat->tahun = date('Y', strtotime($rapat->waktu_mulai));
        $rapat->bulan = date('m', strtotime($rapat->waktu_mulai));

        return view('event.details', [
            'rapat' => $rapat,
            'profil' => $profil,
            'logoLight' => asset('images/gosite/logo-prov-gto.png'),
            'logoDark' => asset('images/gosite/logo-prov-gto-white.png'),
        ]);
    }

    public function proses_upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048',
        ]);

        $file = $request->file('file');
        $file->move(public_path('files/kak'), $file->getClientOriginalName());

        return back()->with('success', 'File berhasil diupload.');
    }
}
