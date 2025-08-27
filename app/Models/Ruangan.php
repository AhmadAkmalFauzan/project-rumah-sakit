<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangans';
    protected $primaryKey = 'idRuangan';
    public $incrementing = false;
    protected $keyType = 'string';


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
        return $this->hasMany(Dokter::class, 'idRuangan', 'idRuangan');
    }
    public function pasien()
    {
        return $this->hasMany(Pasien::class, 'kodeRuangan', 'kodeRuangan');
        // hasMany(ModelTujuan::class, foreignKey_di_tabel_pasien, localKey_di_tabel_ruangan)
    }

     public function kurangi()
    {
        if ($this->dayaTampung > 0) {
            $this->decrement('dayaTampung');
        }
    }

    // Tambah kapasitas
    public function tambah()
    {
        $this->increment('dayaTampung');
    }
}

