<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obats = [
            'Amlodipine 5 mg',
            'Amlodipine 10 mg',
            'Candesartan 16 mg',
            'Lisinopril 5 mg',
            'Lisinopril 10 mg',
            'Miniaspi'
        ];

        foreach ($obats as $obat) {
            \App\Models\MasterObat::create(['nama_obat' => $obat]);
        }
    }
}
