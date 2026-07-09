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
        // 1. Expand the ENUM to accept both old and new values
        DB::statement("ALTER TABLE pasiens MODIFY COLUMN status_merokok ENUM('Ya', 'Tidak', 'Merokok', 'Tidak Merokok', 'Sudah Berhenti Merokok') NULL");

        // 2. Migrate existing data
        DB::table('pasiens')->where('status_merokok', 'Ya')->update(['status_merokok' => 'Merokok']);
        DB::table('pasiens')->where('status_merokok', 'Tidak')->update(['status_merokok' => 'Tidak Merokok']);

        // 3. Restrict the ENUM to only the new values
        DB::statement("ALTER TABLE pasiens MODIFY COLUMN status_merokok ENUM('Merokok', 'Tidak Merokok', 'Sudah Berhenti Merokok') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE pasiens MODIFY COLUMN status_merokok ENUM('Ya', 'Tidak', 'Merokok', 'Tidak Merokok', 'Sudah Berhenti Merokok') NULL");
        
        DB::table('pasiens')->where('status_merokok', 'Merokok')->update(['status_merokok' => 'Ya']);
        DB::table('pasiens')->where('status_merokok', 'Tidak Merokok')->update(['status_merokok' => 'Tidak']);
        DB::table('pasiens')->where('status_merokok', 'Sudah Berhenti Merokok')->update(['status_merokok' => 'Ya']);

        DB::statement("ALTER TABLE pasiens MODIFY COLUMN status_merokok ENUM('Ya', 'Tidak') NULL");
    }
};
