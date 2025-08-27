@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Data Dokter</h2>

        <a href="{{ route('dokter.create') }}" class="btn btn-primary mb-3">
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
                                    {{ $dokter->ruangan ? $dokter->ruangan->namaRuangan . ' (' . $dokter->ruangan->lokasi . ')' : '-' }}
                                </td>

                                <td>{{ $dokter->jamPraktik }}</td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Lihat -->
                                        <a href="{{ route('dokter.show', $dokter->idDokter) }}"
                                            class="btn btn-outline-info btn-sm rounded-circle" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('dokter.edit', $dokter->idDokter) }}"
                                            class="btn btn-outline-warning btn-sm rounded-circle" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Hapus -->
                                        <form action="{{ route('dokter.destroy', $dokter->idDokter) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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