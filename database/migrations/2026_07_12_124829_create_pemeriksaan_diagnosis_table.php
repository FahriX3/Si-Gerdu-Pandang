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
        Schema::create('pemeriksaan_diagnosis', function (Blueprint $table) {
            $table->uuid('id_pemeriksaan');
            $table->uuid('id_diagnosis');
            $table->primary(['id_pemeriksaan', 'id_diagnosis']);
            $table->foreign('id_pemeriksaan')->references('id_pemeriksaan')->on('pemeriksaans')->onDelete('cascade');
            $table->foreign('id_diagnosis')->references('id_diagnosis')->on('master_diagnoses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_diagnosis');
    }
};
