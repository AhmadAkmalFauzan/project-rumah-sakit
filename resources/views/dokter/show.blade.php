@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Detail Dokter</h2>
    <div class="card shadow-sm p-3">
        <p><strong>ID Dokter:</strong> {{ $dokter->idDokter }}</p>
        <p><strong>Nama:</strong> {{ $dokter->namaDokter }}</p>
        <p><strong>Tanggal Lahir:</strong> {{ $dokter->tanggalLahir }}</p>
        <p><strong>Spesialisasi:</strong> {{ $dokter->spesialisasi }}</p>
        <p><strong>Lokasi Praktik:</strong> {{ $dokter->lokasiPraktik }}</p>
        <p><strong>Jam Praktik:</strong> {{ $dokter->jamPraktik }}</p>
        <a href="{{ route('dokter.index') }}" class="btn btn-secondary mt-2">Kembali</a>
    </div>
</div>
@endsection
