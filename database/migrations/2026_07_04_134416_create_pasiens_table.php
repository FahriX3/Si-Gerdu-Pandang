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
        Schema::create('pasiens', function (Blueprint $table) {
            $table->uuid('id_pasien')->primary();
            $table->uuid('id_puskesmas');
            $table->string('nama_lengkap');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16);
            $table->string('no_rm')->nullable();
            $table->string('nama_kepala_keluarga');
            $table->enum('status_peserta', ['Aktif', 'Meninggal', 'Pindah Domisili', 'Non-Aktif']);
            $table->date('tanggal_meninggal')->nullable();
            $table->string('kalurahan');
            $table->string('dukuh')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('no_jkn')->nullable();
            $table->date('tanggal_awal_terdaftar');
            $table->string('jenis_prolanis')->default('HT');
            $table->enum('riwayat_hipertensi_keluarga', ['Ya', 'Tidak', 'Tidak Tahu']);
            $table->string('jenis_pekerjaan');
            $table->enum('status_merokok', ['Ya', 'Tidak']);
            $table->timestamps();
            
            $table->foreign('id_puskesmas')->references('id_puskesmas')->on('master_puskesmas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
