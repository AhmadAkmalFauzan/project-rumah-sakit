@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Dokter</h2>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('dokter.update', $dokter->idDokter) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="idDokter" class="form-label">ID Dokter</label>
            <input type="text" name="idDokter" class="form-control" value="{{ $dokter->idDokter }}" readonly>
        </div>

        <div class="mb-3">
            <label for="namaDokter" class="form-label">Nama Dokter</label>
            <input type="text" name="namaDokter" class="form-control" value="{{ old('namaDokter', $dokter->namaDokter) }}" required>
        </div>

        <div class="mb-3">
            <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggalLahir" class="form-control" value="{{ old('tanggalLahir', $dokter->tanggalLahir) }}" required>
        </div>

        <div class="mb-3">
            <label for="spesialisasi" class="form-label">Spesialisasi</label>
            <input type="text" name="spesialisasi" class="form-control" value="{{ old('spesialisasi', $dokter->spesialisasi) }}" required>
        </div>

        <div class="mb-3">
            <label for="jamPraktik" class="form-label">Jam Praktik</label>
            <input type="text" name="jamPraktik" class="form-control" value="{{ old('jamPraktik', $dokter->jamPraktik) }}" required>
        </div>

        <div class="mb-3">
            <label for="idRuangan" class="form-label">Ruangan</label>
            <select name="idRuangan" class="form-select" required>
                <option value="">-- Pilih Ruangan --</option>
                @foreach($ruangans as $ruangan)
                    <option value="{{ $ruangan->idRuangan }}" {{ old('idRuangan', $dokter->idRuangan) == $ruangan->idRuangan ? 'selected' : '' }}>
                        {{ $ruangan->namaRuangan }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('dokter.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
