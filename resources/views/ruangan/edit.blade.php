@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Ruangan</h2>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('ruangan.update', $ruangan->idRuangan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="idRuangan" class="form-label">ID Ruangan</label>
            <input type="text" name="idRuangan" class="form-control" value="{{ $ruangan->idRuangan }}" required>
        </div>

        <div class="mb-3">
            <label for="kodeRuangan" class="form-label">Kode Ruangan</label>
            <input type="text" name="kodeRuangan" class="form-control" value="{{ old('kodeRuangan', $ruangan->kodeRuangan) }}" required>
        </div>

        <div class="mb-3">
            <label for="namaRuangan" class="form-label">Nama Ruangan</label>
            <input type="text" name="namaRuangan" class="form-control" value="{{ old('namaRuangan', $ruangan->namaRuangan) }}" required>
        </div>

        <div class="mb-3">
            <label for="dayaTampung" class="form-label">Daya Tampung</label>
            <input type="number" name="dayaTampung" class="form-control" value="{{ old('dayaTampung', $ruangan->dayaTampung) }}" required>
        </div>

        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $ruangan->lokasi) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('ruangan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
