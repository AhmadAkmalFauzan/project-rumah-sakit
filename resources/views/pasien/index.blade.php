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

        <a href="{{ route('pasien.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Tambah Pasien
        </a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nomor Rekam</th>
                    <th class="text-center">Nama</th>
                    <th>Usia</th>
                    <th>Jenis Kelamin</th>
                    <th>Penyakit</th>
                    <th class="text-center">Dokter</th>
                    <th class="text-center">Ruangan</th>
                    <th class="text-center">Tanggal Masuk</th>
                    <th class="text-center">Tanggal Keluar</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pasiens as $pasien)
                    <tr>
                        <td>{{ $pasien->NoRekam }}</td>
                        <td>{{ $pasien->namaPasien }}</td>
                        <td>{{ $pasien->usiaPasien }}</td>
                        <td>{{ $pasien->jenisKelamin }}</td>
                        <td>{{ $pasien->penyakitPasien }}</td>
                        <td>{{ $pasien->dokter->namaDokter ?? '-' }}</td>
                        <td>{{ $pasien->ruangan ? $pasien->ruangan->namaRuangan : '-' }}</td>
                        <td>{{ $pasien->tanggalMasuk }}</td>
                        <td>{{ $pasien->tanggalKeluar ?? '-' }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Lihat -->
                                <a href="{{ route('pasien.show', $pasien->NoRekam) }}"
                                    class="btn btn-outline-info btn-sm rounded-circle" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('pasien.edit', $pasien->NoRekam) }}"
                                    class="btn btn-outline-warning btn-sm rounded-circle" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Hapus -->
                                <form action="{{ route('pasien.destroy', $pasien->NoRekam) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus pasien ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection