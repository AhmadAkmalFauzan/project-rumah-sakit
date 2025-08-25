@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Detail Pasien</h2>

    <div class="card p-3">
        <div class="mb-2"><strong>Nomor Rekam:</strong> {{ $pasien->NoRekam }}</div>
        <div class="mb-2"><strong>Nama Pasien:</strong> {{ $pasien->namaPasien }}</div>
        <div class="mb-2"><strong>Usia:</strong> {{ $pasien->usiaPasien }} tahun</div>
        <div class="mb-2"><strong>Jenis Kelamin:</strong> {{ $pasien->jenisKelamin=='L' ? 'Laki-laki' : 'Perempuan' }}</div>
        <div class="mb-2"><strong>Alamat:</strong> {{ $pasien->alamatPasien }}</div>
        <div class="mb-2"><strong>Kota:</strong> {{ $pasien->kotaPasien }}</div>
        <div class="mb-2"><strong>Penyakit:</strong> {{ $pasien->penyakitPasien }}</div>
        <div class="mb-2"><strong>Dokter Penanggung Jawab:</strong> {{ $pasien->dokter->namaDokter ?? '-' }}</div>
        <div class="mb-2"><strong>Ruangan:</strong> {{ $pasien->ruangan->namaRuangan ?? '-' }}</div>
        <div class="mb-2"><strong>Tanggal Masuk:</strong> {{ $pasien->tanggalMasuk }}</div>
        <div class="mb-2"><strong>Tanggal Keluar:</strong> {{ $pasien->tanggalKeluar ?? '-' }}</div>
        <div class="mb-2"><strong>Keterangan:</strong> {{ $pasien->keterangan ?? '-' }}</div>
    </div>

    <a href="{{ route('pasien.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    <a href="{{ route('pasien.edit', $pasien->NoRekam) }}" class="btn btn-warning mt-3">Edit</a>
</div>
@endsection
