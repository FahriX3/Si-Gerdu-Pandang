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
            $table->uuid('id_kelompok_gp')->nullable()->after('id_dukuh');
            
            $table->foreign('id_kelompok_gp')->references('id_kelompok_gp')->on('master_kelompok_gps')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropForeign(['id_kelompok_gp']);
            $table->dropColumn('id_kelompok_gp');
        });
    }
};
