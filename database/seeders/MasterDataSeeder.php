<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterProvinsi;
use App\Models\MasterKabupaten;
use App\Models\MasterKecamatan;
use App\Models\MasterPuskesmas;
use Illuminate\Support\Str;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // Dummy Provinsi
        $prov = MasterProvinsi::updateOrCreate(
            ['id_provinsi' => '34'],
            ['nama_provinsi' => 'DI Yogyakarta']
        );

        // Dummy Kabupaten
        $kab = MasterKabupaten::updateOrCreate(
            ['id_kabupaten' => '3401'],
            ['id_provinsi' => '34', 'nama_kabupaten' => 'Kulon Progo']
        );

        // Kecamatan Kulon Progo
        $kecamatans = [
            '3401010' => 'Temon',
            '3401020' => 'Wates',
            '3401030' => 'Panjatan',
            '3401040' => 'Galur',
            '3401050' => 'Lendah',
            '3401060' => 'Sentolo',
            '3401070' => 'Pengasih',
            '3401080' => 'Kokap',
            '3401090' => 'Girimulyo',
            '3401100' => 'Nanggulan',
            '3401110' => 'Kalibawang',
            '3401120' => 'Samigaluh',
        ];

        foreach ($kecamatans as $id => $nama) {
            MasterKecamatan::updateOrCreate(
                ['id_kecamatan' => $id],
                ['id_kabupaten' => '3401', 'nama_kecamatan' => $nama]
            );
        }

        // Dummy Puskesmas
        MasterPuskesmas::firstOrCreate(
            ['kode_puskesmas' => 'P1001'],
            [
                'id_puskesmas' => Str::uuid(),
                'id_kecamatan' => '3401010',
                'nama_puskesmas' => 'Puskesmas Temon I',
                'alamat' => 'Jl. Raya Temon',
                'no_telp' => '081111111'
            ]
        );
        
        MasterPuskesmas::firstOrCreate(
            ['kode_puskesmas' => 'P1002'],
            [
                'id_puskesmas' => Str::uuid(),
                'id_kecamatan' => '3401010',
                'nama_puskesmas' => 'Puskesmas Temon II',
                'alamat' => 'Jl. Jangkaran Temon',
                'no_telp' => '081111112'
            ]
        );
    }
}
