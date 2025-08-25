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
    public function pasiens()
    {
        return $this->hasMany(Pasien::class, 'kodeRuangan', 'kodeRuangan');
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

