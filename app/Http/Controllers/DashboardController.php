<?php
namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\MasterPuskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private function applyFilters($pasienQuery, $pemeriksaanQuery, Request $request)
    {
        $user = auth()->user();
        if ($user->role === 'admin_dinkes' && $request->filled('id_puskesmas')) {
            $pasienQuery->where('id_puskesmas', $request->id_puskesmas);
            $pemeriksaanQuery->whereHas('pasien', function($q) use ($request) {
                $q->where('id_puskesmas', $request->id_puskesmas);
            });
        }
        if ($request->filled('id_kelurahan')) {
            $pasienQuery->where('id_kelurahan', $request->id_kelurahan);
            $pemeriksaanQuery->whereHas('pasien', function($q) use ($request) {
                $q->where('id_kelurahan', $request->id_kelurahan);
            });
        }
        if ($request->filled('tahun')) {
            $pasienQuery->whereYear('tanggal_awal_terdaftar', $request->tahun);
            $pemeriksaanQuery->whereYear('tanggal_pemeriksaan', $request->tahun);
        }
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        
        $pasienQuery = Pasien::query();
        $pemeriksaanQuery = Pemeriksaan::query();
        
        // Simpan referensi query murni untuk Hipertensi sebelum difilter tahun
        $htQuery = Pemeriksaan::where('diagnosis', 'HT tidak terkontrol')
            ->whereDate('tanggal_pemeriksaan', '>=', now()->subDays(30));

        // Untuk apply kalurahan & puskesmas ke HT query
        if ($user->role === 'admin_dinkes' && $request->filled('id_puskesmas')) {
            $htQuery->whereHas('pasien', function($q) use ($request) {
                $q->where('id_puskesmas', $request->id_puskesmas);
            });
        }
        if ($request->filled('id_kelurahan')) {
            $htQuery->whereHas('pasien', function($q) use ($request) {
                $q->where('id_kelurahan', $request->id_kelurahan);
            });
        }

        $this->applyFilters($pasienQuery, $pemeriksaanQuery, $request);

        $totalPasien = $pasienQuery->count();
        $totalPemeriksaan = $pemeriksaanQuery->count();
        $pasienHipertensiTidakTerkontrol = $htQuery->count();
            
        // Fetch graph data Distribusi
        $distQuery = clone $pasienQuery;
        if ($user->role === 'admin_dinkes' && !$request->filled('id_puskesmas')) {
            $grafikData = $distQuery->select('master_puskesmas.nama_puskesmas as label', DB::raw('count(pasiens.id_pasien) as total'))
                ->join('master_puskesmas', 'pasiens.id_puskesmas', '=', 'master_puskesmas.id_puskesmas')
                ->groupBy('master_puskesmas.nama_puskesmas')
                ->get();
        } else {
            $grafikData = $distQuery->select('master_kelurahans.nama_kelurahan as label', DB::raw('count(pasiens.id_pasien) as total'))
                ->join('master_kelurahans', 'pasiens.id_kelurahan', '=', 'master_kelurahans.id_kelurahan')
                ->groupBy('master_kelurahans.nama_kelurahan')
                ->get();
        }

        // Fetch Trend Data
        $tahun = $request->input('tahun', date('Y'));
        
        $trendQuery = Pemeriksaan::query();
        // apply puskesmas/kalurahan filter to trend without filtering year directly yet
        if ($user->role === 'admin_dinkes' && $request->filled('id_puskesmas')) {
            $trendQuery->whereHas('pasien', function($q) use ($request) {
                $q->where('id_puskesmas', $request->id_puskesmas);
            });
        }
        if ($request->filled('id_kelurahan')) {
            $trendQuery->whereHas('pasien', function($q) use ($request) {
                $q->where('id_kelurahan', $request->id_kelurahan);
            });
        }
        
        $pemeriksaanTrend = $trendQuery->whereYear('tanggal_pemeriksaan', $tahun)
            ->select(DB::raw('MONTH(tanggal_pemeriksaan) as bulan'), DB::raw('count(id_pemeriksaan) as total'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $trendData = array_fill(1, 12, 0);
        foreach($pemeriksaanTrend as $pt) {
            $trendData[$pt->bulan] = $pt->total;
        }
        $trendValues = array_values($trendData);

        // Required data for filters
        $puskesmas = MasterPuskesmas::all();
        
        if ($user->role === 'admin_dinkes') {
            if ($request->filled('id_puskesmas')) {
                $kalurahans = \App\Models\MasterKelurahan::where('id_puskesmas', $request->id_puskesmas)->orderBy('nama_kelurahan')->get();
            } else {
                $kalurahans = \App\Models\MasterKelurahan::orderBy('nama_kelurahan')->get();
            }
        } else {
            $kalurahans = \App\Models\MasterKelurahan::where('id_puskesmas', $user->id_puskesmas)->orderBy('nama_kelurahan')->get();
        }
        
        $filters = [
            'id_puskesmas' => $request->id_puskesmas,
            'id_kelurahan' => $request->id_kelurahan,
            'tahun' => $tahun,
        ];

        return view('dashboard', compact('totalPasien', 'totalPemeriksaan', 'pasienHipertensiTidakTerkontrol', 'grafikData', 'trendValues', 'puskesmas', 'kalurahans', 'filters'));
    }

    public function exportPdf(Request $request)
    {
        $user = auth()->user();
        
        $pasienQuery = Pasien::query();
        $pemeriksaanQuery = Pemeriksaan::query();
        
        $htQuery = Pemeriksaan::where('diagnosis', 'HT tidak terkontrol')
            ->whereDate('tanggal_pemeriksaan', '>=', now()->subDays(30));

        // Untuk apply kalurahan & puskesmas ke HT query
        if ($user->role === 'admin_dinkes' && $request->filled('id_puskesmas')) {
            $htQuery->whereHas('pasien', function($q) use ($request) {
                $q->where('id_puskesmas', $request->id_puskesmas);
            });
        }
        if ($request->filled('id_kelurahan')) {
            $htQuery->whereHas('pasien', function($q) use ($request) {
                $q->where('id_kelurahan', $request->id_kelurahan);
            });
        }

        $this->applyFilters($pasienQuery, $pemeriksaanQuery, $request);

        $totalPasien = $pasienQuery->count();
        $totalPemeriksaan = $pemeriksaanQuery->count();
        $pasienHipertensiTidakTerkontrol = $htQuery->count();
            
        $distQuery = clone $pasienQuery;
        if ($user->role === 'admin_dinkes' && !$request->filled('id_puskesmas')) {
            $grafikData = $distQuery->select('master_puskesmas.nama_puskesmas as label', DB::raw('count(pasiens.id_pasien) as total'))
                ->join('master_puskesmas', 'pasiens.id_puskesmas', '=', 'master_puskesmas.id_puskesmas')
                ->groupBy('master_puskesmas.nama_puskesmas')
                ->get();
            $title = 'Distribusi Pasien Per Puskesmas';
        } else {
            $grafikData = $distQuery->select('master_kelurahans.nama_kelurahan as label', DB::raw('count(pasiens.id_pasien) as total'))
                ->join('master_kelurahans', 'pasiens.id_kelurahan', '=', 'master_kelurahans.id_kelurahan')
                ->groupBy('master_kelurahans.nama_kelurahan')
                ->get();
            $title = 'Distribusi Pasien Per Kalurahan';
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.pdf', compact('totalPasien', 'totalPemeriksaan', 'pasienHipertensiTidakTerkontrol', 'grafikData', 'title'));
        return $pdf->download('Statistik_Ringkasan_Eksekutif_' . date('Ymd') . '.pdf');
    }
}
