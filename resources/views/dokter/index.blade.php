@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Data Dokter</h2>

    <a href="{{ route('dokter.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Dokter
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>ID Dokter</th>
                        <th>Nama</th>
                        <th>Spesialisasi</th>
                        <th>Lokasi Praktik</th>
                        <th>Jam Praktik</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dokters as $dokter)
                        <tr>
                            <td>{{ $dokter->idDokter }}</td>
                            <td>{{ $dokter->namaDokter }}</td>
                            <td>{{ $dokter->spesialisasi }}</td>
                            <td>
    {{ $dokter->ruangan ? $dokter->ruangan->namaRuangan.' ('.$dokter->ruangan->lokasi.')' : '-' }}
</td>

                            <td>{{ $dokter->jamPraktik }}</td>
                            <td>
                                <a href="{{ route('dokter.show', $dokter->idDokter) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('dokter.edit', $dokter->idDokter) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('dokter.destroy', $dokter->idDokter) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data dokter</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
