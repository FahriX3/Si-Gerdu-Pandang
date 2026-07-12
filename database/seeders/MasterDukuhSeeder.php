<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterDukuhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Jangkaran' => ['Jangkaran', 'Kledekan Kidul', 'Kledekan Lor', 'Ngelak', 'Ngentak', 'Nglawang', 'Pasir Kadilangu', 'Pasir Mendit'],
            'Palihan' => ['Kragon 1', 'Kragon 2', 'Mlangsen', 'Munggangan', 'Ngringgit', 'Palihan 1', 'Palihan 2', 'Selong', 'Tanggalan'],
            'Karangwuluh' => ['Candi Kulon', 'Candi Wetan', 'Karangwuluh Kidul', 'Karangwuluh Lor'],
            'Kebonrejo' => ['Dumpoh', 'Kibon', 'Seling', 'Weton'],
            'Janten' => ['Dukuh', 'Janten', 'Jomboran', 'Tegalrejo', 'Tegalsari'],
            'Sindutan' => ['Bayeman', 'Dukuh', 'Glaheng', 'Penginan', 'Plempukan', 'Sindutan A', 'Sindutan B'],
            'Glagah' => ['Bapangan', 'Bebekan', 'Kepek', 'Kretek', 'Logede', 'Macanan', 'Sangkretan', 'Sidorejo'],
        ];

        foreach ($data as $kelurahan => $dukuhs) {
            $kel = \App\Models\MasterKelurahan::where('nama_kelurahan', $kelurahan)->first();
            if ($kel) {
                foreach ($dukuhs as $dukuh) {
                    \App\Models\MasterDukuh::create([
                        'id_kelurahan' => $kel->id_kelurahan,
                        'nama_dukuh' => $dukuh,
                    ]);
                }
            }
        }
    }
}
