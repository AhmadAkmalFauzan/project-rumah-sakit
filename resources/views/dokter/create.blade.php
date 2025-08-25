@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Tambah Dokter</h2>

    <form action="{{ route('dokter.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

      <div class="mb-3">
    <label class="form-label">ID Dokter</label>
    <input type="text" name="idDokter" class="form-control" value="{{ old('idDokter') }}" required>
    @error('idDokter')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>
        <div class="mb-3">
            <label class="form-label">Nama Dokter</label>
            <input type="text" name="namaDokter" class="form-control" value="{{ old('namaDokter') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggalLahir" class="form-control" value="{{ old('tanggalLahir') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Spesialisasi</label>
            <select name="spesialisasi" class="form-select" required>
                <option value="">-- Pilih Spesialisasi --</option>
                <option value="Poli Umum">Poli Umum</option>
                <option value="Poli Gigi">Poli Gigi</option>
                <option value="Poli Anak">Poli Anak</option>
                <option value="Poli Mata">Poli Mata</option>
                <option value="Poli Kulit">Poli Kulit</option>
                <option value="Poli Penyakit Dalam">Poli Penyakit Dalam</option>
                <option value="Poli Konseling">Poli Konseling</option>
                <option value="Poli THT">Poli THT</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ruangan</label>
            <select name="idRuangan" class="form-select" required>
                  @foreach($ruangans as $ruangan)
        <option value="{{ $ruangan->idRuangan }}">{{ $ruangan->namaRuangan }}</option>
    @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jam Praktik</label>
            <input type="time" name="jamPraktik" class="form-control" value="{{ old('jamPraktik') }}" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('dokter.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
        </div>
    </form>
</div>
@endsection
