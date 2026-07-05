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
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('id_puskesmas')->nullable()->after('id');
            $table->enum('role', ['admin_dinkes', 'admin_puskesmas', 'petugas_pustu', 'kader_posyandu'])->default('petugas_pustu')->after('password');
            
            $table->foreign('id_puskesmas')->references('id_puskesmas')->on('master_puskesmas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_puskesmas']);
            $table->dropColumn(['id_puskesmas', 'role']);
        });
    }
};
