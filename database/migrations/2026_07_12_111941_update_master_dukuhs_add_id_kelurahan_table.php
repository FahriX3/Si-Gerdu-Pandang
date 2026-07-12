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
        Schema::table('master_dukuhs', function (Blueprint $table) {
            $table->dropColumn('nama_kelurahan');
            $table->uuid('id_kelurahan')->after('id_dukuh');
            
            $table->foreign('id_kelurahan')->references('id_kelurahan')->on('master_kelurahans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_dukuhs', function (Blueprint $table) {
            $table->dropForeign(['id_kelurahan']);
            $table->dropColumn('id_kelurahan');
            $table->string('nama_kelurahan')->after('id_dukuh');
        });
    }
};
