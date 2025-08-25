@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Daftar Pasien</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('pasien.create') }}" class="btn btn-primary mb-3">Tambah Pasien</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nomor Rekam</th>
                <th>Nama</th>
                <th>Usia</th>
                <th>Jenis Kelamin</th>
                <th>Penyakit</th>
                <th>Dokter</th>
                <th>Ruangan</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pasiens as $pasien)
            <tr>
                <td>{{ $pasien->NomorRekam }}</td>
                <td>{{ $pasien->namaPasien }}</td>
                <td>{{ $pasien->usiaPasien }}</td>
                <td>{{ $pasien->jenisKelamin }}</td>
                <td>{{ $pasien->penyakitPasien }}</td>
                <td>{{ $pasien->dokter->namaDokter ?? '-' }}</td>
                <td>{{ $pasien->ruangan->namaRuangan ?? '-' }}</td>
                <td>{{ $pasien->tanggalMasuk }}</td>
                <td>{{ $pasien->tanggalKeluar ?? '-' }}</td>
                <td>
                    <a href="{{ route('pasien.show', $pasien->NomorRekam) }}" class="btn btn-info btn-sm">Lihat</a>
                    <a href="{{ route('pasien.edit', $pasien->NomorRekam) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('pasien.destroy', $pasien->NomorRekam) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pasien ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
