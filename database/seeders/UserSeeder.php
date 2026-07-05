<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\MasterPuskesmas;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Dinkes (No Puskesmas)
        User::create([
            'name' => 'Admin Dinkes',
            'email' => 'admin@dinkes.com',
            'password' => Hash::make('password'),
            'role' => 'admin_dinkes',
            'id_puskesmas' => null
        ]);

        // Petugas Puskesmas (Assigned to Temon II)
        $puskesmas = MasterPuskesmas::where('nama_puskesmas', 'Puskesmas Temon II')->first();
        if ($puskesmas) {
            User::create([
                'name' => 'Petugas Temon II',
                'email' => 'petugas@temon2.com',
                'password' => Hash::make('password'),
                'role' => 'admin_puskesmas',
                'id_puskesmas' => $puskesmas->id_puskesmas
            ]);
        }
    }
}
