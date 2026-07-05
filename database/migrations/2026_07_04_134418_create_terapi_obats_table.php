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
        Schema::create('terapi_obats', function (Blueprint $table) {
            $table->uuid('id_terapi')->primary();
            $table->uuid('id_pemeriksaan');
            $table->string('nama_obat');
            $table->string('aturan_pakai');
            $table->integer('jumlah_obat');
            $table->timestamps();
            
            $table->foreign('id_pemeriksaan')->references('id_pemeriksaan')->on('pemeriksaans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terapi_obats');
    }
};
