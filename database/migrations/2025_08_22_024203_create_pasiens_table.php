<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->string('NoRekam')->primary();
            $table->string('namaPasien');
            $table->date('tanggalLahir');
            $table->integer('usiaPasien');
            $table->string('jenisKelamin');
            $table->string('alamatPasien');
            $table->string('kotaPasien');
            $table->string('penyakitPasien');
            $table->string('idDokter');
            $table->date('tanggalMasuk');
            $table->date('tanggalKeluar')->nullable();
            $table->string('kodeRuangan');
            $table->text('keterangan')->nullable();
            $table->timestamps(); // wajib biar Laravel tidak error
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
    