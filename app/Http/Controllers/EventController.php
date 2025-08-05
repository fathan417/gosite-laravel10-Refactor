<?php

namespace App\Http\Controllers;

use App\Models\Rapat;
use App\Models\Pegawai;
use App\Models\EventSiteContent;
use App\Models\RapatUndanganInternal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Services\UserInfoService;

class EventController extends Controller
{
    public function index()
    {
        $rapat = Rapat::select('id', 'judul', 'waktu_mulai', 'waktu_selesai', 'tempat', 'created_by')
            ->where('created_by', 15)
            ->get();

        return view('event', [
            'sidebar' => 'Event',
            'rapat' => $rapat,
        ]);
    }

    public function addEvent()
    {
        $pegawai = Pegawai::select('id', 'nama')->get();

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

        Rapat::create([
            'judul' => $validated['namakeg'],
            'pj_id' => $validated['namaket'],
            'waktu_mulai' => $validated['tgl_mulai'],
            'waktu_selesai' => $validated['tgl_selesai'],
            'tempat' => $validated['tempat'],
            'kak' => $path,
            'created_by' => Auth::id(),
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

        $rapat = Rapat::with(['jenis', 'undangan', 'contents'])
            ->findOrFail($id);

       
        $undangan = RapatUndanganInternal::query()
            ->where('rapat_id', $rapat->id)
            ->where('asal', $profil->asal)
            ->where($profil->asal == '2' ? 'id_pegawai' : 'id_tamu', $profil->id)
            ->first();

        $rapat->role = $undangan?->role ?? 0;

        
        $rapat->contents->each(function ($c) {
            $c->linkstat = 'show';
        });


        $rapat->jenis_nama = $rapat->jenis->pluck('nama')->toArray();
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
