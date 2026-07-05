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
        Schema::create('pemeriksaans', function (Blueprint $table) {
            $table->uuid('id_pemeriksaan')->primary();
            $table->uuid('id_pasien');
            $table->unsignedBigInteger('id_user')->nullable(); // nullable if user is deleted
            $table->date('tanggal_pemeriksaan');
            $table->enum('tempat_pemeriksaan', ['Puskesmas', 'Pustu', 'Posyandu Lansia', 'Lainnya']);
            $table->text('keluhan');
            $table->decimal('berat_badan', 5, 2);
            $table->decimal('tinggi_badan', 5, 2);
            $table->decimal('lingkar_perut', 5, 2);
            $table->integer('systole');
            $table->integer('diastole');
            $table->integer('nadi');
            $table->enum('diagnosis', ['HT terkontrol', 'HT tidak terkontrol']);
            $table->text('catatan')->nullable();
            $table->date('tanggal_pemberian_obat')->nullable();
            $table->integer('gula_darah_puasa')->nullable();
            $table->integer('gula_darah_sewaktu')->nullable();
            $table->integer('kolesterol_total')->nullable();
            $table->decimal('asam_urat', 4, 1)->nullable();
            $table->string('path_foto_lab')->nullable();
            $table->timestamps();
            
            $table->foreign('id_pasien')->references('id_pasien')->on('pasiens')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaans');
    }
};
