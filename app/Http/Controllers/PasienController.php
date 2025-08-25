<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PasienController extends Controller
{
    public function index()
    {
        $pasiens = Pasien::with(['dokter','ruangan'])->get();
        return view('pasien.index', compact('pasiens'));
    }

    public function create()
    {
        $penyakitList = Dokter::select('spesialisasi')->distinct()->pluck('spesialisasi');
        $ruangans = Ruangan::all(); // tampilkan semua, cek kapasitas di controller
        return view('pasien.create', compact('penyakitList','ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NoRekam'       => 'required|unique:pasiens,NoRekam',
            'namaPasien'    => 'required',
            'tanggalLahir'  => 'required|date',
            'jenisKelamin'  => 'required|in:L,P',
            'alamatPasien'  => 'required',
            'kotaPasien'    => 'required',
            'penyakitPasien'=> 'required',
            'idDokter'      => 'required|exists:dokters,idDokter',
            'tanggalMasuk'  => 'required|date',
            'kodeRuangan'   => 'required|exists:ruangans,idRuangan',
            'keterangan'    => 'nullable|string',
        ]);

        $ruangan = Ruangan::findOrFail($request->kodeRuangan);

        // cek kapasitas
        if($ruangan->current_capacity >= $ruangan->dayaTampung){
            return redirect()->back()->with('error','Ruangan penuh, pilih ruangan lain.');
        }

        $usia = Carbon::parse($request->tanggalLahir)->age;

        Pasien::create([
            'NoRekam'        => $request->NoRekam,
            'namaPasien'     => $request->namaPasien,
            'tanggalLahir'   => $request->tanggalLahir,
            'usiaPasien'     => $usia,
            'jenisKelamin'   => $request->jenisKelamin,
            'alamatPasien'   => $request->alamatPasien,
            'kotaPasien'     => $request->kotaPasien,
            'penyakitPasien' => $request->penyakitPasien,
            'idDokter'       => $request->idDokter,
            'tanggalMasuk'   => $request->tanggalMasuk,
            'tanggalKeluar'  => $request->tanggalKeluar,
            'kodeRuangan'    => $request->kodeRuangan,
            'keterangan'     => $request->keterangan
        ]);

        $ruangan->increment('current_capacity');

        return redirect()->route('pasien.index')->with('success','Pasien berhasil ditambahkan.');
    }

    public function edit(Pasien $pasien)
    {
        $penyakitList = Dokter::select('spesialisasi')->distinct()->pluck('spesialisasi');
        $ruangans = Ruangan::all();
        $dokters = Dokter::where('spesialisasi', $pasien->penyakitPasien)->get();
        return view('pasien.edit', compact('pasien','penyakitList','ruangans','dokters'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $request->validate([
            'namaPasien'    => 'required',
            'tanggalLahir'  => 'required|date',
            'jenisKelamin'  => 'required|in:L,P',
            'alamatPasien'  => 'required',
            'kotaPasien'    => 'required',
            'penyakitPasien'=> 'required',
            'idDokter'      => 'required|exists:dokters,idDokter',
            'tanggalMasuk'  => 'required|date',
            'kodeRuangan'   => 'required|exists:ruangans,idRuangan',
            'keterangan'    => 'nullable|string',
        ]);

        $usia = Carbon::parse($request->tanggalLahir)->age;

        $ruanganBaru = Ruangan::findOrFail($request->kodeRuangan);
        if($pasien->kodeRuangan != $ruanganBaru->idRuangan){
            $ruanganLama = Ruangan::find($pasien->kodeRuangan);
            if($ruanganLama) $ruanganLama->decrement('current_capacity');
            $ruanganBaru->increment('current_capacity');
        }

        $pasien->update([
            'namaPasien'     => $request->namaPasien,
            'tanggalLahir'   => $request->tanggalLahir,
            'usiaPasien'     => $usia,
            'jenisKelamin'   => $request->jenisKelamin,
            'alamatPasien'   => $request->alamatPasien,
            'kotaPasien'     => $request->kotaPasien,
            'penyakitPasien' => $request->penyakitPasien,
            'idDokter'       => $request->idDokter,
            'tanggalMasuk'   => $request->tanggalMasuk,
            'tanggalKeluar'  => $request->tanggalKeluar,
            'kodeRuangan'    => $request->kodeRuangan,
            'keterangan'     => $request->keterangan
        ]);

        return redirect()->route('pasien.index')->with('success','Pasien berhasil diperbarui.');
    }

    public function destroy(Pasien $pasien)
    {
        $ruangan = Ruangan::find($pasien->kodeRuangan);
        if($ruangan) $ruangan->decrement('current_capacity');
        $pasien->delete();

        return redirect()->route('pasien.index')->with('success','Pasien berhasil dihapus.');
    }

    // API helper untuk ajax dokter
    public function getDokterByPenyakit($penyakit)
    {
        $dokters = Dokter::where('spesialisasi', $penyakit)->get();
        return response()->json($dokters);
    }
}
