@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-house-door"></i> Detail Ruangan
            </h5>
            <a href="{{ route('ruangan.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>ID Ruangan:</strong> {{ $ruangan->idRuangan }}
                </li>
                <li class="list-group-item">
                    <strong>Kode Ruangan:</strong> {{ $ruangan->kodeRuangan }}
                </li>
                <li class="list-group-item">
                    <strong>Nama Ruangan:</strong> {{ $ruangan->namaRuangan }}
                </li>
                <li class="list-group-item">
                    <strong>Daya Tampung:</strong> {{ $ruangan->dayaTampung }}
                </li>
                <li class="list-group-item">
                    <strong>Lokasi:</strong> {{ $ruangan->lokasi }}
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
