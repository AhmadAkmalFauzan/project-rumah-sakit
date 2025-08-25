<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::with('ruangan')->get();
        return view('dokter.index', compact('dokters'));
    }

    public function create()
    {
        $ruangans = Ruangan::all();
        return view('dokter.create', compact('ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idDokter'     => 'required|unique:dokters,idDokter',
            'namaDokter'   => 'required',
            'tanggalLahir' => 'required|date',
            'spesialisasi' => 'required',
            'jamPraktik'   => 'required',
            'idRuangan'    => 'required|exists:ruangans,idRuangan',
        ]);

        Dokter::create($request->only([
            'idDokter',
            'namaDokter',
            'tanggalLahir',
            'spesialisasi',
            'jamPraktik',
            'idRuangan'
        ]));

        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil ditambahkan');
    }

    public function edit($idDokter)
    {
        $dokter = Dokter::findOrFail($idDokter);
        $ruangans = Ruangan::all();
        return view('dokter.edit', compact('dokter', 'ruangans'));
    }

    public function update(Request $request, $idDokter)
    {
        $request->validate([
            'namaDokter'   => 'required',
            'tanggalLahir' => 'required|date',
            'spesialisasi' => 'required',
            'jamPraktik'   => 'required',
            'idRuangan'    => 'required|exists:ruangans,idRuangan',
        ]);

        $dokter = Dokter::findOrFail($idDokter);
        $dokter->update($request->only([
            'namaDokter',
            'tanggalLahir',
            'spesialisasi',
            'jamPraktik',
            'idRuangan'
        ]));

        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil diperbarui');
    }

    public function destroy($idDokter)
    {
        $dokter = Dokter::findOrFail($idDokter);
        $dokter->delete();
        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil dihapus');
    }

    public function show($idDokter)
    {
        $dokter = Dokter::with('ruangan')->findOrFail($idDokter);
        return view('dokter.show', compact('dokter'));
    }
}
