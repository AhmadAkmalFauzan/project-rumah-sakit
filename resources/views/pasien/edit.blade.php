@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Pasien</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pasien.update', $pasien->NomorRekam) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nomor Rekam Pasien</label>
            <input type="text" name="NomorRekam" class="form-control" value="{{ $pasien->NomorRekam }}" readonly>
        </div>

        <div class="mb-3">
            <label>Nama Pasien</label>
            <input type="text" name="namaPasien" class="form-control" value="{{ old('namaPasien',$pasien->namaPasien) }}" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggalLahir" class="form-control" value="{{ old('tanggalLahir',$pasien->tanggalLahir) }}" required>
        </div>

        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenisKelamin" class="form-select" required>
                <option value="L" {{ old('jenisKelamin',$pasien->jenisKelamin)=='L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenisKelamin',$pasien->jenisKelamin)=='P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamatPasien" class="form-control" value="{{ old('alamatPasien',$pasien->alamatPasien) }}" required>
        </div>

        <div class="mb-3">
            <label>Kota</label>
            <input type="text" name="kotaPasien" class="form-control" value="{{ old('kotaPasien',$pasien->kotaPasien) }}" required>
        </div>

        <div class="mb-3">
            <label>Penyakit</label>
            <select name="penyakitPasien" id="penyakitPasien" class="form-select" required>
                <option value="">-- Pilih Penyakit --</option>
                @foreach($penyakitList as $penyakit)
                    <option value="{{ $penyakit }}" {{ $pasien->penyakitPasien==$penyakit ? 'selected' : '' }}>{{ $penyakit }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Dokter</label>
            <select name="idDokter" id="dokterPasien" class="form-select" required>
                <option value="">-- Pilih Dokter --</option>
                @foreach($dokters as $dokter)
                    <option value="{{ $dokter->idDokter }}" {{ $pasien->idDokter==$dokter->idDokter ? 'selected' : '' }}>{{ $dokter->namaDokter }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Masuk</label>
            <input type="date" name="tanggalMasuk" class="form-control" value="{{ old('tanggalMasuk',$pasien->tanggalMasuk) }}" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Keluar</label>
            <input type="date" name="tanggalKeluar" class="form-control" value="{{ old('tanggalKeluar',$pasien->tanggalKeluar) }}">
        </div>

        <div class="mb-3">
            <label>Ruangan</label>
            <select name="kodeRuangan" class="form-select" required>
                <option value="">-- Pilih Ruangan --</option>
                @foreach($ruangans as $ruangan)
                    <option value="{{ $ruangan->idRuangan }}" {{ $pasien->kodeRuangan==$ruangan->idRuangan ? 'selected' : '' }}>
                        {{ $ruangan->namaRuangan }} (Sisa: {{ $ruangan->dayaTampung }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan',$pasien->keterangan) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('pasien.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Update dokter jika penyakit berubah
    $('#penyakitPasien').change(function(){
        var penyakit = $(this).val();
        if(penyakit){
            $.ajax({
                url: '/api/dokter-by-penyakit/' + penyakit,
                type: 'GET',
                success: function(data){
                    $('#dokterPasien').empty();
