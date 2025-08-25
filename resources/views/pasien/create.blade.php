@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah Pasien</h2>

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

    <form action="{{ route('pasien.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nomor Rekam Pasien</label>
            <input type="text" name="NoRekam" class="form-control" value="{{ old('NoRekam') }}" required>
        </div>

        <div class="mb-3">
            <label>Nama Pasien</label>
            <input type="text" name="namaPasien" class="form-control" value="{{ old('namaPasien') }}" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggalLahir" class="form-control" value="{{ old('tanggalLahir') }}" required>
        </div>

        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenisKelamin" class="form-select" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L" {{ old('jenisKelamin')=='L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenisKelamin')=='P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamatPasien" class="form-control" value="{{ old('alamatPasien') }}" required>
        </div>

        <div class="mb-3">
            <label>Kota</label>
            <input type="text" name="kotaPasien" class="form-control" value="{{ old('kotaPasien') }}" required>
        </div>

        <div class="mb-3">
            <label>Penyakit</label>
            <select name="penyakitPasien" id="penyakitPasien" class="form-select" required>
                <option value="">-- Pilih Penyakit --</option>
                @foreach($penyakitList as $penyakit)
                    <option value="{{ $penyakit }}" {{ old('penyakitPasien')==$penyakit ? 'selected' : '' }}>{{ $penyakit }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Dokter</label>
            <select name="idDokter" id="dokterPasien" class="form-select" required>
                <option value="">-- Pilih Dokter --</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Masuk</label>
            <input type="date" name="tanggalMasuk" class="form-control" value="{{ old('tanggalMasuk') }}" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Keluar</label>
            <input type="date" name="tanggalKeluar" class="form-control" value="{{ old('tanggalKeluar') }}">
        </div>

        <div class="mb-3">
            <label>Ruangan</label>
            <select name="kodeRuangan" class="form-select" required>
                <option value="">-- Pilih Ruangan --</option>
                @foreach($ruangans as $ruangan)
                    <option value="{{ $ruangan->idRuangan }}">{{ $ruangan->namaRuangan }} (Sisa: {{ $ruangan->dayaTampung }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pasien.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Ambil dokter berdasarkan penyakit menggunakan Ajax
    $('#penyakitPasien').change(function(){
        var penyakit = $(this).val();
        if(penyakit){
            $.ajax({
                url: '/api/dokter-by-penyakit/' + penyakit,
                type: 'GET',
                success: function(data){
                    $('#dokterPasien').empty();
                    $('#dokterPasien').append('<option value="">-- Pilih Dokter --</option>');
                    $.each(data, function(key, value){
                        $('#dokterPasien').append('<option value="'+value.idDokter+'">'+value.namaDokter+'</option>');
                    });
                }
            });
        }else{
            $('#dokterPasien').empty().append('<option value="">-- Pilih Dokter --</option>');
        }
    });
</script>
@endsection
