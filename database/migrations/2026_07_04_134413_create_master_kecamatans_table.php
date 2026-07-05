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
        Schema::create('master_kecamatans', function (Blueprint $table) {
            $table->char('id_kecamatan', 7)->primary();
            $table->char('id_kabupaten', 4);
            $table->string('nama_kecamatan');
            $table->timestamps();
            
            $table->foreign('id_kabupaten')->references('id_kabupaten')->on('master_kabupatens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_kecamatans');
    }
};
