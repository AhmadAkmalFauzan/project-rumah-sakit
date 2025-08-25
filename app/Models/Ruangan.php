<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
      protected $table = 'ruangans';
    protected $primaryKey = 'idRuangan';
    public $incrementing = false; // ✅ karena bukan auto increment
    protected $keyType = 'string'; // ✅ kalau idRuangan string
    

     public $timestamps = false;

    protected $fillable = [
    'idRuangan',
    'kodeRuangan',
    'namaRuangan',
    'dayaTampung',
    'lokasi',
    'current_capacity'
    ];
     public function dokters()
{
    return $this->hasMany(Dokter::class, 'idRuangan','idRuangan');
}
     public function pasiens() {
        return $this->hasMany(Pasien::class, 'kodeRuangan', 'idRuangan');
    }
}

