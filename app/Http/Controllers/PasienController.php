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
        $pasiens = Pasien::with(['dokter', 'ruangan'])->get();
        return view('pasien.index', compact('pasiens'));
    }

    public function create()
    {
        $penyakitList = Dokter::select('spesialisasi')->distinct()->pluck('spesialisasi');
        $ruangans = Ruangan::all(); // tampilkan semua, cek kapasitas di controller
        return view('pasien.create', compact('penyakitList', 'ruangans'));
    }

    public function store(Request $request)
    {

        $rawKode = trim((string) $request->input('kodeRuangan'));

        // Kalau yang terkirim bukan kode yang valid, coba anggap itu idRuangan lalu map ke kodeRuangan
        if (!Ruangan::where('kodeRuangan', $rawKode)->exists()) {
            $mapped = Ruangan::where('idRuangan', $rawKode)->value('kodeRuangan');
            if ($mapped) {
                $request->merge(['kodeRuangan' => $mapped]);
            } else {
                // biar error validasi rapi
                $request->merge(['kodeRuangan' => $rawKode]);
            }
        } else {
            // paksa rapi (hapus spasi, opsional kapital)
            $request->merge(['kodeRuangan' => $rawKode]); // atau strtoupper($rawKode) kalau semua kode huruf besar
        }

        $validated = $request->validate([
            'NoRekam' => 'required|unique:pasiens,NoRekam',
            'namaPasien' => 'required',
            'tanggalLahir' => 'required|date|before_or_equal:today',
            'jenisKelamin' => 'required|in:L,P',
            'alamatPasien' => 'required',
            'kotaPasien' => 'required',
            'penyakitPasien' => 'required',
            'idDokter' => 'required|exists:dokters,idDokter',
            'tanggalMasuk' => 'required|date|before_or_equal:today',
            'tanggalKeluar' => 'nullable|date|after_or_equal:tanggalMasuk',
            'kodeRuangan' => 'required|exists:ruangans,kodeRuangan',
            'keterangan' => 'nullable|string',
        ]);

        // cari ruangan berdasarkan kodeRuangan
        $ruangan = Ruangan::where('kodeRuangan', $request->kodeRuangan)->first();

        // cek kapasitas (kalau dayaTampung sudah 0 berarti penuh)
        if ($ruangan->dayaTampung <= 0) {
            return redirect()->back()->with('error', 'Ruangan penuh, pilih ruangan lain.');
        }
        if ($request->tanggalKeluar === null) {
            if ($ruangan->current_capacity >= $ruangan->dayaTampung) {
                return redirect()->back()->with('error', 'Ruangan penuh, pilih ruangan lain.');
            }
        }
        if ($request->tanggalKeluar === null) {
            $ruangan->increment('current_capacity');
        }

        // hitung usia otomatis
        $usia = Carbon::parse($request->tanggalLahir)->age;

        // simpan pasien
        Pasien::create([
            'NoRekam' => $request->NoRekam,
            'namaPasien' => $request->namaPasien,
            'tanggalLahir' => $request->tanggalLahir,
            'usiaPasien' => $usia,
            'jenisKelamin' => $request->jenisKelamin,
            'alamatPasien' => $request->alamatPasien,
            'kotaPasien' => $request->kotaPasien,
            'penyakitPasien' => $request->penyakitPasien,
            'idDokter' => $request->idDokter,
            'tanggalMasuk' => $request->tanggalMasuk,
            'tanggalKeluar' => $request->tanggalKeluar,
            'kodeRuangan' => $request->kodeRuangan,
            'keterangan' => $request->keterangan,
        ]);

        // kurangi daya tampung karena 1 pasien masuk
        $ruangan->decrement('dayaTampung');

        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function edit(Pasien $pasien)
    {
        $penyakitList = Dokter::select('spesialisasi')->distinct()->pluck('spesialisasi');
        $ruangans = Ruangan::all();
        $dokters = Dokter::where('spesialisasi', $pasien->penyakitPasien)->get();
        return view('pasien.edit', compact('pasien', 'penyakitList', 'ruangans', 'dokters'));
    }
    public function update(Request $request, Pasien $pasien)
    {
        $request->validate([
            'namaPasien' => 'required',
            'tanggalLahir' => 'required|date|before_or_equal:today',
            'jenisKelamin' => 'required|in:L,P',
            'alamatPasien' => 'required',
            'kotaPasien' => 'required',
            'penyakitPasien' => 'required',
            'idDokter' => 'required|exists:dokters,idDokter',
            'tanggalMasuk' => 'required|date|before_or_equal:today',
            'kodeRuangan' => 'required|exists:ruangans,kodeRuangan',
            'tanggalKeluar' => 'nullable|date|after_or_equal:tanggalMasuk',
            'keterangan' => 'nullable|string',
        ]);

        $usia = Carbon::parse($request->tanggalLahir)->age;

        // simpan kondisi lama
        $oldKodeRuangan = $pasien->kodeRuangan;
        $oldTanggalKeluar = $pasien->tanggalKeluar;

        // update pasien
        $pasien->update([
            'namaPasien' => $request->namaPasien,
            'tanggalLahir' => $request->tanggalLahir,
            'usiaPasien' => $usia,
            'jenisKelamin' => $request->jenisKelamin,
            'alamatPasien' => $request->alamatPasien,
            'kotaPasien' => $request->kotaPasien,
            'penyakitPasien' => $request->penyakitPasien,
            'idDokter' => $request->idDokter,
            'tanggalMasuk' => $request->tanggalMasuk,
            'tanggalKeluar' => $request->tanggalKeluar,
            'kodeRuangan' => $request->kodeRuangan,
            'keterangan' => $request->keterangan,
        ]);

        $ruanganLama = Ruangan::where('kodeRuangan', $oldKodeRuangan)->first();
        $ruanganBaru = Ruangan::where('kodeRuangan', $request->kodeRuangan)->first();

        // pasien pindah ruangan
        if ($oldKodeRuangan !== $request->kodeRuangan) {
            // kurangi ruangan lama (kalau pasien dulu belum keluar)
            if ($ruanganLama && $oldTanggalKeluar === null && $ruanganLama->current_capacity > 0) {
                $ruanganLama->increment('dayaTampung');
            }
            // tambah ke ruangan baru (kalau pasien belum keluar sekarang)
            if ($ruanganBaru && $request->tanggalKeluar === null) {
                if ($ruanganBaru->current_capacity < $ruanganBaru->dayaTampung) {
                    $ruanganBaru->decrement('dayaTampung');
                } else {
                    return back()->with('error', 'Ruangan baru penuh!');
                }
            }
        }
        // pasien tetap di ruangan yang sama
        else {
            if ($ruanganLama) {
                // kasus: dulu aktif, sekarang keluar → kapasitas berkurang
                if ($oldTanggalKeluar === null && $request->tanggalKeluar !== null) {
                    if ($ruanganLama->current_capacity > 0) {
                        $ruanganLama->increment('dayaTampung');
                    }
                }
                // kasus: dulu keluar, sekarang aktif lagi → kapasitas nambah
                if ($oldTanggalKeluar !== null && $request->tanggalKeluar === null) {
                    if ($ruanganLama->current_capacity < $ruanganLama->dayaTampung) {
                        $ruanganLama->decrement('dayaTampung');
                    } else {
                        return back()->with('error', 'Ruangan penuh, pasien tidak bisa masuk lagi.');
                    }
                }
            }
        }

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Pasien $pasien)
    {
        // Cari ruangan pasien
        $ruangan = Ruangan::where('kodeRuangan', $pasien->kodeRuangan)->first();

        $masihDiruangan = !$pasien->tanggalKeluar || \Carbon\Carbon::parse($pasien->tanggalKeluar)->isFuture();

        if ($masihDiruangan) {
            // kembalikan slot ruangan karena pasien dihapus sebelum keluar
            if ($ruangan) {
                $ruangan->increment('dayaTampung');
            }
        }

        // Hapus pasien
        $pasien->delete();

        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil dihapus.');
    }

    public function show(Pasien $pasien)
    {

        return view('pasien.show', compact('pasien'));
    }


    // API helper untuk ajax dokter
    public function getDokterByPenyakit($penyakit)
    {
        $dokters = Dokter::where('spesialisasi', $penyakit)->get();
        return response()->json($dokters);
    }
}
