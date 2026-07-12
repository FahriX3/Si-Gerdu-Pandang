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
            $table->dropColumn('diagnosis');
            $table->decimal('lila', 5, 2)->nullable();
            
            $table->decimal('ureum', 6, 2)->nullable();
            $table->decimal('kreatinin', 6, 2)->nullable();
            $table->decimal('egfr', 6, 2)->nullable();
            $table->decimal('hdl', 6, 2)->nullable();
            $table->decimal('ldl', 6, 2)->nullable();
            $table->decimal('rasio_kolesterol_hdl', 6, 2)->nullable();
            $table->decimal('sgpt', 6, 2)->nullable();
            $table->decimal('mikroalbumin_kuantitatif', 6, 2)->nullable();
            
            $table->text('hasil_ekg')->nullable();
            $table->string('dokumen_ekg')->nullable();
            $table->enum('prediksi_risiko_kardiovaskular', ['< 5 %', '5 - < 10 %', '10 - < 20 %', '20 - < 30 %', '> 30 %'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeriksaans', function (Blueprint $table) {
            $table->string('diagnosis')->nullable();
            $table->dropColumn([
                'lila', 'ureum', 'kreatinin', 'egfr', 'hdl', 'ldl',
                'rasio_kolesterol_hdl', 'sgpt', 'mikroalbumin_kuantitatif',
                'hasil_ekg', 'dokumen_ekg', 'prediksi_risiko_kardiovaskular'
            ]);
        });
    }
};
