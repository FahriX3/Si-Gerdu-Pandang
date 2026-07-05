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
        Schema::create('master_kabupatens', function (Blueprint $table) {
            $table->char('id_kabupaten', 4)->primary();
            $table->char('id_provinsi', 2);
            $table->string('nama_kabupaten');
            $table->timestamps();
            
            $table->foreign('id_provinsi')->references('id_provinsi')->on('master_provinsis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_kabupatens');
    }
};
