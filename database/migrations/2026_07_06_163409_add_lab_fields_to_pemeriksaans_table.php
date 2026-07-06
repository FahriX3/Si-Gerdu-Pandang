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
        Schema::table('pemeriksaans', function (Blueprint $table) {
            $table->string('kategori_kolesterol')->nullable();
            $table->decimal('trigliserida', 5, 2)->nullable();
            $table->string('kategori_trigliserida')->nullable();
            $table->string('kategori_asam_urat')->nullable();
            $table->decimal('hba1c', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeriksaans', function (Blueprint $table) {
            $table->dropColumn([
                'kategori_kolesterol',
                'trigliserida',
                'kategori_trigliserida',
                'kategori_asam_urat',
                'hba1c',
            ]);
        });
    }
};
