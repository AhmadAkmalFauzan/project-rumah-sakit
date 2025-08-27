@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Daftar Ruangan</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('ruangan.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Tambah Ruangan
        </a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Ruangan</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Daya Tampung</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ruangans as $ruangan)
                    <tr>
                        <td>{{ $ruangan->idRuangan }}</td>
                        <td>{{ $ruangan->kodeRuangan }}</td>
                        <td>{{ $ruangan->namaRuangan }}</td>
                        <td>{{ $ruangan->dayaTampung }}</td>
                        <td>{{ $ruangan->lokasi }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Lihat -->
                                <a href="{{ route('ruangan.show', $ruangan->idRuangan) }}"
                                    class="btn btn-outline-info btn-sm rounded-circle" data-bs-toggle="tooltip" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('ruangan.edit', $ruangan->idRuangan) }}"
                                    class="btn btn-outline-warning btn-sm rounded-circle" data-bs-toggle="tooltip" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Hapus -->
                                <form action="{{ route('ruangan.destroy', $ruangan->idRuangan) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus ruangan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle"
                                        data-bs-toggle="tooltip" title="Hapus">
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