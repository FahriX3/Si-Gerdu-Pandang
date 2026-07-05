<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Thanks to Global Scopes in the models, Pasien::count() 
        // automatically filters by id_puskesmas for non-admin users.
        $totalPasien = Pasien::count();
        $totalPemeriksaan = Pemeriksaan::count();
        $pasienHipertensiTidakTerkontrol = Pemeriksaan::where('diagnosis', 'HT tidak terkontrol')
            ->whereDate('tanggal_pemeriksaan', '>=', now()->subDays(30))
            ->count();
            
        // Fetch graph data
        if ($user->role === 'admin_dinkes') {
            $grafikData = Pasien::select('master_puskesmas.nama_puskesmas as label', DB::raw('count(pasiens.id_pasien) as total'))
                ->join('master_puskesmas', 'pasiens.id_puskesmas', '=', 'master_puskesmas.id_puskesmas')
                ->groupBy('master_puskesmas.nama_puskesmas')
                ->get();
        } else {
            $grafikData = Pasien::select('kalurahan as label', DB::raw('count(id_pasien) as total'))
                ->groupBy('kalurahan')
                ->get();
        }

        return view('dashboard', compact('totalPasien', 'totalPemeriksaan', 'pasienHipertensiTidakTerkontrol', 'grafikData'));
    }
}
