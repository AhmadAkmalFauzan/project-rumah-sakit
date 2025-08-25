<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokters', function (Blueprint $table) {
            $table->id();
            $table->char('idDokter');   
            $table->text('namaDokter');
            $table->date('tanggalLahir');
            $table->text('spesialisasi');
             $table->string('lokasiPraktik')->nullable()    ;
            $table->text('jamPraktik');
          
             
            // relasi pakai idRuangan (manual input, bukan auto increment)
            $table->string('idRuangan');
            $table->foreign('idRuangan')->references('idRuangan')->on('ruangans')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokters');
    }
};
