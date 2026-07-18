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
        Schema::create('master_kelompok_gps', function (Blueprint $table) {
            $table->uuid('id_kelompok_gp')->primary();
            $table->uuid('id_puskesmas')->nullable();
            $table->string('nama_kelompok_gp');
            $table->timestamps();
            
            $table->foreign('id_puskesmas')->references('id_puskesmas')->on('master_puskesmas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_kelompok_gps');
    }
};
