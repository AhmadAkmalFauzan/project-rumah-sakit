<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Prompts\Table;

class Pasien extends Model
{
    use HasFactory;

    protected $table = "pasiens";

    protected $primaryKey = 'NoRekam';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'NoRekam', 'namaPasien', 'tanggalLahir', 'usiaPasien',
        'jenisKelamin', 'alamatPasien', 'kotaPasien', 'penyakitPasien',
        'idDokter', 'tanggalMasuk', 'tanggalKeluar', 'kodeRuangan', 'keterangan'
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'idDokter');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'kodeRuangan', 'kodeRuangan');
    }
}
