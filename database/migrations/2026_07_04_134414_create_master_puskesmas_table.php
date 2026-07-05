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
        Schema::create('master_puskesmas', function (Blueprint $table) {
            $table->uuid('id_puskesmas')->primary();
            $table->char('id_kecamatan', 7);
            $table->string('kode_puskesmas')->unique();
            $table->string('nama_puskesmas');
            $table->text('alamat');
            $table->string('no_telp')->nullable();
            $table->timestamps();
            
            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('master_kecamatans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_puskesmas');
    }
};
