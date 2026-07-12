<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemeriksaan;
use App\Models\MasterPuskesmas;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $puskesmas = [];
        $kelurahans = [];
        if (auth()->user()->role === 'admin_dinkes') {
            $puskesmas = MasterPuskesmas::all();
            $kelurahans = \App\Models\MasterKelurahan::orderBy('nama_kelurahan')->get();
        } else {
            $kelurahans = \App\Models\MasterKelurahan::where('id_puskesmas', auth()->user()->id_puskesmas)->orderBy('nama_kelurahan')->get();
        }
        
        return view('laporan.index', compact('puskesmas', 'kelurahans'));
    }

    private function getFilteredData(Request $request)
    {
        $query = Pemeriksaan::with(['pasien.puskesmas', 'pemeriksa', 'terapiObats']);

        // Filter based on role
        if (auth()->user()->role !== 'admin_dinkes') {
            $query->whereHas('pasien', function ($q) {
                $q->where('id_puskesmas', auth()->user()->id_puskesmas);
            });
        } elseif ($request->filled('id_puskesmas')) {
            $query->whereHas('pasien', function ($q) use ($request) {
                $q->where('id_puskesmas', $request->id_puskesmas);
            });
        }

        // Date Filter
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_pemeriksaan', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_pemeriksaan', '<=', $request->tanggal_akhir);
        }

        // Tensi Filter
        if ($request->filled('kategori_tensi')) {
            $query->where('kategori_tensi', $request->kategori_tensi);
        }

        // IMT Filter
        if ($request->filled('status_imt')) {
            $query->where('status_imt', $request->status_imt);
        }

        if ($request->filled('id_kelurahan')) {
            $query->whereHas('pasien', function ($q) use ($request) {
                $q->where('id_kelurahan', $request->id_kelurahan);
            });
        }

        return $query->orderBy('tanggal_pemeriksaan', 'desc')->orderBy('created_at', 'desc')->get();
    }

    public function preview(Request $request)
    {
        $pemeriksaans = $this->getFilteredData($request);
        
        $data = $pemeriksaans->map(function($p) {
            $obatText = "";
            if ($p->terapiObats && count($p->terapiObats) > 0) {
                $obatList = [];
                foreach ($p->terapiObats as $ob) {
                    $obatList[] = $ob->nama_obat . " (" . $ob->aturan_pakai . ")";
                }
                $obatText = implode("; ", $obatList);
            }

            return [
                'tanggal_pemeriksaan' => $p->tanggal_pemeriksaan->format('d/m/Y'),
                'nik' => $p->pasien->nik ?? '-',
                'nama_pasien' => $p->pasien->nama_lengkap ?? '-',
                'jenis_kelamin' => $p->pasien->jenis_kelamin ?? '-',
                'usia' => $p->pasien->umur ?? '-',
                'alamat' => $p->pasien->alamat ?? '-',
                'kalurahan' => $p->pasien->kelurahan->nama_kelurahan ?? '-',
                'puskesmas' => $p->pasien->puskesmas->nama_puskesmas ?? '-',
                'tensi' => $p->systole . '/' . $p->diastole,
                'kategori_tensi' => $p->kategori_tensi,
                'tb' => $p->tinggi_badan,
                'bb' => $p->berat_badan,
                'lp' => $p->lingkar_perut,
                'imt' => $p->imt,
                'status_imt' => $p->status_imt,
                'diagnosis' => $p->diagnoses->pluck('nama_diagnosis')->join(', '),
                'obat' => $obatText,
                'petugas' => $p->pemeriksa->name ?? '-'
            ];
        });

        return response()->json($data);
    }

    public function exportCsv(Request $request)
    {
        $pemeriksaans = $this->getFilteredData($request);
        
        $filename = "laporan_pemeriksaan_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'Tanggal Pemeriksaan', 'No KTP/NIK', 'Nama Pasien', 'Jenis Kelamin', 'Usia', 
            'Alamat', 'Kalurahan', 'Puskesmas', 'Systole', 'Diastole', 'Kategori Tensi', 
            'Tinggi Badan (cm)', 'Berat Badan (kg)', 'Lingkar Perut (cm)', 
            'IMT', 'Status IMT', 'Diagnosis', 'Terapi/Obat', 'Petugas'
        ];

        $callback = function() use($pemeriksaans, $columns) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 compatibility
            fputs($file, "\xEF\xBB\xBF");
            
            fputcsv($file, $columns, ';');

            foreach ($pemeriksaans as $p) {
                // Parse obat
                $obatText = "";
                if ($p->terapiObats && count($p->terapiObats) > 0) {
                    $obatList = [];
                    foreach ($p->terapiObats as $ob) {
                        $obatList[] = $ob->nama_obat . " (" . $ob->aturan_pakai . ")";
                    }
                    $obatText = implode("; ", $obatList);
                }

                $row = [
                    $p->tanggal_pemeriksaan->format('d/m/Y'),
                    $p->pasien->nik ?? '-',
                    $p->pasien->nama_lengkap ?? '-',
                    $p->pasien->jenis_kelamin ?? '-',
                    $p->pasien->umur ?? '-',
                    $p->pasien->alamat ?? '-',
                    $p->pasien->kalurahan ?? '-',
                    $p->pasien->puskesmas->nama_puskesmas ?? '-',
                    $p->systole,
                    $p->diastole,
                    $p->kategori_tensi,
                    $p->tinggi_badan,
                    $p->berat_badan,
                    $p->lingkar_perut,
                    $p->imt,
                    $p->status_imt,
                    $p->diagnoses->pluck('nama_diagnosis')->join(', '),
                    $obatText,
                    $p->pemeriksa->name ?? '-'
                ];

                fputcsv($file, $row, ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $pemeriksaans = $this->getFilteredData($request);
        
        $filterTexts = [];
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $filterTexts[] = "Periode: " . $request->tanggal_awal . " s/d " . $request->tanggal_akhir;
        }
        if ($request->filled('id_puskesmas')) {
            $pusk = MasterPuskesmas::find($request->id_puskesmas);
            if ($pusk) $filterTexts[] = "Puskesmas: " . $pusk->nama_puskesmas;
        }
        if ($request->filled('kalurahan')) {
            $filterTexts[] = "Kalurahan: " . $request->kalurahan;
        }

        $pdf = Pdf::loadView('laporan.pdf', [
            'pemeriksaans' => $pemeriksaans,
            'filters' => $filterTexts,
            'user' => auth()->user()
        ]);
        
        // Use landscape for reports with many columns
        $pdf->setPaper('A4', 'landscape');

        $filename = "laporan_pemeriksaan_" . date('Ymd_His') . ".pdf";
        return $pdf->download($filename);
    }

    public function register(Request $request)
    {
        $puskesmas = [];
        $kelurahans = [];
        if (auth()->user()->role === 'admin_dinkes') {
            $puskesmas = MasterPuskesmas::all();
            $kelurahans = \App\Models\MasterKelurahan::orderBy('nama_kelurahan')->get();
        } else {
            $kelurahans = \App\Models\MasterKelurahan::where('id_puskesmas', auth()->user()->id_puskesmas)->orderBy('nama_kelurahan')->get();
        }
        
        $tahun = $request->input('tahun', date('Y'));
        
        $pasienQuery = \App\Models\Pasien::with(['pemeriksaans' => function($q) use ($tahun) {
            $q->whereYear('tanggal_pemeriksaan', $tahun)
              ->with('terapiObats')
              ->orderBy('tanggal_pemeriksaan', 'asc');
        }]);

        if (auth()->user()->role !== 'admin_dinkes') {
            $pasienQuery->where('pasiens.id_puskesmas', auth()->user()->id_puskesmas);
        } else if ($request->filled('id_puskesmas')) {
            $pasienQuery->where('pasiens.id_puskesmas', $request->id_puskesmas);
        }

        if ($request->filled('id_kelurahan')) {
            $pasienQuery->where('pasiens.id_kelurahan', $request->id_kelurahan);
        }
        
        $pasiens = $pasienQuery->orderBy('nama_lengkap', 'asc')->get();

        return view('laporan.register', compact('puskesmas', 'kelurahans', 'pasiens', 'tahun'));
    }
}
