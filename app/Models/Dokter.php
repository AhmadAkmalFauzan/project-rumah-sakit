<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokters';
    protected $primaryKey = 'idDokter';
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = [
        'idDokter',
        'namaDokter',
        'tanggalLahir',
        'spesialisasi',
        'lokasiPraktik',
        'jamPraktik',
        'idRuangan',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'idRuangan', 'idRuangan');
    }
      public function pasiens() {
        return $this->hasMany(Pasien::class, 'idDokter', 'idDokter');
    }
}
