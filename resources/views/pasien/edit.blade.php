@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Pasien</h4>
        </div>
        <div class="card-body">
            
            {{-- Alert Error --}}
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error) 
                            <li>{{ $error }}</li> 
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pasien.update', $pasien->NoRekam) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nomor Rekam --}}
                <div class="mb-3">
                    <label class="form-label">Nomor Rekam Pasien</label>
                    <input type="text" name="NoRekam" 
                           class="form-control" 
                           value="{{ $pasien->NoRekam }}" readonly>
                </div>

                {{-- Nama Pasien --}}
                <div class="mb-3">
                    <label class="form-label">Nama Pasien</label>
                    <input type="text" name="namaPasien" 
                           class="form-control" 
                           value="{{ old('namaPasien',$pasien->namaPasien) }}" required>
                </div>

                {{-- Tanggal Lahir --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggalLahir" 
                           class="form-control" 
                           value="{{ old('tanggalLahir',$pasien->tanggalLahir) }}" required>
                </div>

                {{-- Jenis Kelamin --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenisKelamin" class="form-select" required>
                        <option value="L" {{ old('jenisKelamin',$pasien->jenisKelamin)=='L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenisKelamin',$pasien->jenisKelamin)=='P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                {{-- Alamat --}}
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamatPasien" 
                           class="form-control" 
                           value="{{ old('alamatPasien',$pasien->alamatPasien) }}" required>
                </div>

                {{-- Kota --}}
                <div class="mb-3">
                    <label class="form-label">Kota</label>
                    <input type="text" name="kotaPasien" 
                           class="form-control" 
                           value="{{ old('kotaPasien',$pasien->kotaPasien) }}" required>
                </div>

                {{-- Penyakit --}}
                <div class="mb-3">
                    <label class="form-label">Penyakit</label>
                    <select name="penyakitPasien" id="penyakitPasien" class="form-select" required>
                        <option value="">-- Pilih Penyakit --</option>
                        @foreach($penyakitList as $penyakit)
                            <option value="{{ $penyakit }}" {{ $pasien->penyakitPasien==$penyakit ? 'selected' : '' }}>
                                {{ $penyakit }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Dokter --}}
                <div class="mb-3">
                    <label class="form-label">Dokter</label>
                    <select name="idDokter" id="dokterPasien" class="form-select" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($dokters as $dokter)
                            <option value="{{ $dokter->idDokter }}" {{ $pasien->idDokter==$dokter->idDokter ? 'selected' : '' }}>
                                {{ $dokter->namaDokter }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tanggal Masuk --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Masuk</label>
                    <input type="date" name="tanggalMasuk" 
                           class="form-control" 
                           value="{{ old('tanggalMasuk',$pasien->tanggalMasuk) }}" required>
                </div>

                {{-- Tanggal Keluar --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Keluar</label>
                    <input type="date" name="tanggalKeluar" 
                           class="form-control" 
                           value="{{ old('tanggalKeluar',$pasien->tanggalKeluar) }}">
                </div>

                {{-- Ruangan --}}
                <div class="mb-3">
                    <label class="form-label">Ruangan</label>
                    <select name="kodeRuangan" class="form-select" required>
                        <option value="">-- Pilih Ruangan --</option>
                        @foreach($ruangans as $ruangan)
                            <option value="{{ $ruangan->kodeRuangan }}" 
                                {{ $pasien->kodeRuangan==$ruangan->kodeRuangan ? 'selected' : '' }}>
                                {{ $ruangan->namaRuangan }} 
                                (Sisa: {{ $ruangan->dayaTampung - $ruangan->current_capacity }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Keterangan --}}
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control">{{ old('keterangan',$pasien->keterangan) }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">Update</button>
                    <a href="{{ route('pasien.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- jQuery Ajax update dokter --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#penyakitPasien').change(function(){
        var penyakit = $(this).val();
        if(penyakit){
            $.ajax({
                url: '/api/dokter-by-penyakit/' + penyakit,
                type: 'GET',
                success: function(data){
                    $('#dokterPasien').empty().append('<option value="">-- Pilih Dokter --</option>');
                    $.each(data, function(key, dokter){
                        $('#dokterPasien').append('<option value="'+dokter.idDokter+'">'+dokter.namaDokter+'</option>');
                    });
                }
            });
        }
    });
</script>
@endsection
