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
            $table->dropColumn(['kalurahan', 'dukuh']);
            
            $table->uuid('id_kelurahan')->nullable()->after('tanggal_meninggal');
            $table->uuid('id_dukuh')->nullable()->after('id_kelurahan');
            
            $table->foreign('id_kelurahan')->references('id_kelurahan')->on('master_kelurahans')->onDelete('restrict');
            $table->foreign('id_dukuh')->references('id_dukuh')->on('master_dukuhs')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropForeign(['id_kelurahan']);
            $table->dropForeign(['id_dukuh']);
            
            $table->dropColumn(['id_kelurahan', 'id_dukuh']);
            
            $table->string('kalurahan')->nullable()->after('tanggal_meninggal');
            $table->string('dukuh')->nullable()->after('kalurahan');
        });
    }
};
