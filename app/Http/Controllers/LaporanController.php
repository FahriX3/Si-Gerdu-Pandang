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
        if (auth()->user()->role === 'admin_dinkes') {
            $puskesmas = MasterPuskesmas::all();
        }
        
        return view('laporan.index', compact('puskesmas'));
    }

    private function getFilteredData(Request $request)
    {
        $query = Pemeriksaan::with(['pasien.puskesmas', 'pemeriksa']);

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

        return $query->orderBy('tanggal_pemeriksaan', 'desc')->get();
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
            'Alamat', 'Puskesmas', 'Systole', 'Diastole', 'Kategori Tensi', 
            'Tinggi Badan (cm)', 'Berat Badan (kg)', 'Lingkar Perut (cm)', 
            'IMT', 'Status IMT', 'Diagnosis', 'Terapi/Obat', 'Petugas'
        ];

        $callback = function() use($pemeriksaans, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($pemeriksaans as $p) {
                // Parse obat
                $obatText = "";
                if ($p->obat && count($p->obat) > 0) {
                    $obatList = [];
                    foreach ($p->obat as $ob) {
                        $obatList[] = $ob['nama'] . " (" . $ob['aturan'] . ")";
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
                    $p->pasien->puskesmas->nama_puskesmas ?? '-',
                    $p->systole,
                    $p->diastole,
                    $p->kategori_tensi,
                    $p->tinggi_badan,
                    $p->berat_badan,
                    $p->lingkar_perut,
                    $p->imt,
                    $p->status_imt,
                    $p->diagnosis,
                    $obatText,
                    $p->pemeriksa->name ?? '-'
                ];

                fputcsv($file, $row);
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
}
