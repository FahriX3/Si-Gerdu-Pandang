<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterKelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $puskesmas = \App\Models\MasterPuskesmas::where('nama_puskesmas', 'like', '%Temon II%')->first();
        if ($puskesmas) {
            $kelurahans = [
                'Jangkaran', 'Sindutan', 'Palihan', 'Glagah', 'Kebonrejo', 'Janten', 'Karangwuluh'
            ];
            foreach ($kelurahans as $kel) {
                \App\Models\MasterKelurahan::firstOrCreate([
                    'id_puskesmas' => $puskesmas->id_puskesmas,
                    'nama_kelurahan' => $kel
                ]);
            }
        }
    }
}
