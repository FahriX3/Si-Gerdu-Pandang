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
        Schema::table('pasiens', function (Blueprint $table) {
            $table->string('no_kk', 16)->nullable()->change();
            $table->string('nama_kepala_keluarga')->nullable()->change();
            $table->string('jenis_pekerjaan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->string('no_kk', 16)->nullable(false)->change();
            $table->string('nama_kepala_keluarga')->nullable(false)->change();
            $table->string('jenis_pekerjaan')->nullable(false)->change();
        });
    }
};
