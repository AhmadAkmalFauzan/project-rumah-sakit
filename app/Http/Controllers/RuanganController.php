<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    // Tampilkan semua ruangan
    public function index()
    {
        $ruangans = Ruangan::all();
        if (Auth::check()) {
            return view('ruangan.index', compact('ruangans'));
        } else {
            return view('login');
        }
    }

    // Form tambah ruangan
    public function create()
    {
        return view('ruangan.create');
    }

    // Simpan ruangan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idRuangan'   => 'required|string|max:255|unique:ruangans,idRuangan',
            'kodeRuangan' => 'required|string|max:50|unique:ruangans,kodeRuangan',
            'namaRuangan' => 'required|string|max:255',
            'dayaTampung' => 'required|integer',
            'lokasi'      => 'required|string|max:255',
        ], [
            'kodeRuangan.unique' => 'Kode Ruangan sudah digunakan.',
            'idRuangan.unique'   => 'ID Ruangan sudah digunakan.',
        ]);

        Ruangan::create($validated);

        return redirect()->route('ruangan.index')->with('success', 'Data ruangan berhasil ditambahkan.');
    }

    // Lihat detail ruangan
    public function show(Ruangan $ruangan)
    {
        return view('ruangan.show', compact('ruangan'));
    }

    // Form edit ruangan
    public function edit(Ruangan $ruangan)
    {
        return view('ruangan.edit', compact('ruangan'));
    }

    // Update ruangan
    public function update(Request $request, Ruangan $ruangan)
    {
        $validated = $request->validate([
            'idRuangan'   => 'required|string|max:255|unique:ruangans,idRuangan,' . $ruangan->idRuangan . ',idRuangan',
            'kodeRuangan' => 'required|string|max:50',
            'namaRuangan' => 'required|string|max:255',
            'dayaTampung' => 'required|integer',
            'lokasi'      => 'required|string|max:255',
        ]);

        $ruangan->update($validated);

        return redirect()->route('ruangan.index')->with('success', 'Data ruangan berhasil diperbarui.');
    }

    // Hapus ruangan
    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();
        return redirect()->route('ruangan.index')->with('success', 'Data ruangan berhasil dihapus.');
    }
}
