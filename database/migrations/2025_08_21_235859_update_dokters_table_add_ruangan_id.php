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
         Schema::table('dokters', function (Blueprint $table) {
        $table->dropColumn('lokasiPraktik');
        $table->unsignedBigInteger('idRuangan')->after('spesialisasi');
        $table->foreign('idRuangan')->references('id')->on('ruangans')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokters', function (Blueprint $table) {
        $table->string('lokasiPraktik')->nullable();
    });
    }
};
