<?php

namespace App\Http\Controllers;

use App\Models\Rapat;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Presensi;

class PresensiController extends Controller
{
    public function show($id)
    {
        $rapat = Rapat::findOrFail($id);
        $provinsi = Province::orderBy('name')->get();
        return view('presensi.form', compact('rapat', 'provinsi'));
    }


    public function submit(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'province_id' => 'nullable|string|size:2',
            'regency_id' => 'nullable|string|size:4',
            'signature' => 'nullable|string',
        ]);

        Presensi::create([
            'event_id' => $id,
            'nama' => $request->nama,
            'instansi' => $request->instansi,
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
            'signature' => $request->signature,
        ]);

        return back()->with('success', 'Presensi berhasil dikirim!');
    }

    public function showForm($token)
    {
        $rapat = Rapat::where('token_link', $token)->firstOrFail();
        $provinsi = Province::orderBy('name')->get();
        return view('presensi.form', compact('rapat', 'provinsi'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:rapat,id',
            'nama' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'province_id' => 'nullable|string|size:2',
            'regency_id' => 'nullable|string|size:4',
            'signature' => 'nullable|string',
        ]);

        Presensi::create($request->all());

        return redirect()->back()->with('success', 'Presensi berhasil disimpan!');
    }

}
