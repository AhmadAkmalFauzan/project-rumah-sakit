@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Daftar Ruangan</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('ruangan.create') }}" class="btn btn-primary mb-3">Tambah Ruangan</a>

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
                        <td>
                            <a href="{{ route('ruangan.show', $ruangan->idRuangan) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('ruangan.edit', $ruangan->idRuangan) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('ruangan.destroy', $ruangan->idRuangan) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus ruangan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection