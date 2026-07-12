<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use App\Models\Pasien;
use App\Models\TerapiObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemeriksaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemeriksaan::with(['pasien', 'pemeriksa'])
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->orderBy('created_at', 'desc');
        
        if (auth()->user()->role !== 'admin_dinkes') {
            $query->whereHas('pasien', function ($q) {
                $q->where('id_puskesmas', auth()->user()->id_puskesmas);
            });
        } elseif ($request->filled('id_puskesmas')) {
            $query->whereHas('pasien', function ($q) use ($request) {
                $q->where('id_puskesmas', $request->id_puskesmas);
            });
        }

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('pasien', function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        }
        
        $pemeriksaans = $query->paginate(10);
        $puskesmas = auth()->user()->role === 'admin_dinkes' ? \App\Models\MasterPuskesmas::all() : [];
        return view('pemeriksaan.index', compact('pemeriksaans', 'puskesmas'));
    }

    public function create(Request $request)
    {
        // For the autocomplete
        $pasiens = Pasien::with(['puskesmas', 'kelurahan', 'dukuhM'])->get();
        $obats = \App\Models\MasterObat::orderBy('nama_obat')->get();
        $diagnoses = \App\Models\MasterDiagnosis::orderBy('nama_diagnosis')->get();
        $puskesmas = auth()->user()->role === 'admin_dinkes' ? \App\Models\MasterPuskesmas::orderBy('nama_puskesmas')->get() : collect();
        return view('pemeriksaan.create', compact('pasiens', 'obats', 'puskesmas', 'diagnoses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pasien' => 'required|exists:pasiens,id_pasien',
            'tanggal_pemeriksaan' => 'required|date',
            'tempat_pemeriksaan' => 'nullable|string',
            'keluhan' => 'required|string',
            'berat_badan' => 'required|numeric|min:0|max:999',
            'tinggi_badan' => 'required|numeric|min:0|max:999',
            'lingkar_perut' => 'required|numeric|min:0|max:999',
            'lila' => 'nullable|numeric|min:0|max:999',
            'systole' => 'required|integer|min:0|max:999',
            'diastole' => 'required|integer|min:0|max:999',
            'nadi' => 'required|integer|min:0|max:999',
            'diagnoses' => 'required|array|min:1',
            'diagnoses.*' => 'required|exists:master_diagnoses,id_diagnosis',
            'catatan' => 'nullable|string',
            'tanggal_pemberian_obat' => 'nullable|date',
            
            // Lab Fields
            'gula_darah_puasa' => 'nullable|numeric|min:0|max:999',
            'gula_darah_sewaktu' => 'nullable|numeric|min:0|max:999',
            'kolesterol_total' => 'nullable|numeric|min:0|max:999',
            'asam_urat' => 'nullable|numeric|min:0|max:999',
            'hba1c' => 'nullable|numeric|min:0|max:999',
            'ureum' => 'nullable|numeric|min:0|max:999',
            'kreatinin' => 'nullable|numeric|min:0|max:999',
            'egfr' => 'nullable|numeric|min:0|max:999',
            'hdl' => 'nullable|numeric|min:0|max:999',
            'ldl' => 'nullable|numeric|min:0|max:999',
            'trigliserida' => 'nullable|numeric|min:0|max:999',
            'rasio_kolesterol_hdl' => 'nullable|numeric|min:0|max:999',
            'sgpt' => 'nullable|numeric|min:0|max:999',
            'mikroalbumin_kuantitatif' => 'nullable|numeric|min:0|max:999',
            'dokumen_lab' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            
            // EKG Fields
            'hasil_ekg' => 'nullable|string',
            'dokumen_ekg' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'prediksi_risiko_kardiovaskular' => 'nullable|in:< 5 %,5 - < 10 %,10 - < 20 %,20 - < 30 %,> 30 %',
            
            // Therapy Arrays
            'nama_obat' => 'required|array|min:1',
            'nama_obat.*' => 'required|string',
            'aturan_pakai' => 'required|array|min:1',
            'aturan_pakai.*' => 'required|string',
            'jumlah_obat' => 'required|array|min:1',
            'jumlah_obat.*' => 'required|integer',
        ]);

        $validated['id_user'] = auth()->id();

        if ($request->hasFile('dokumen_lab')) {
            $path = $request->file('dokumen_lab')->store('lab_documents', 'public');
            $validated['dokumen_lab'] = $path;
        }

        if ($request->hasFile('dokumen_ekg')) {
            $pathEkg = $request->file('dokumen_ekg')->store('ekg_documents', 'public');
            $validated['dokumen_ekg'] = $pathEkg;
        }

        // Auto-assign tempat pemeriksaan based on patient's puskesmas
        $pasien = Pasien::with('puskesmas')->find($validated['id_pasien']);
        $validated['tempat_pemeriksaan'] = $pasien->puskesmas->nama_puskesmas ?? 'Puskesmas';

        DB::beginTransaction();
        try {
            $pemeriksaan = Pemeriksaan::create($validated);
            
            // Sync multiple diagnoses
            if ($request->has('diagnoses') && is_array($request->diagnoses)) {
                $pemeriksaan->diagnoses()->sync($request->diagnoses);
            }

            if ($request->has('nama_obat') && is_array($request->nama_obat)) {
                foreach ($request->nama_obat as $index => $obat) {
                    if (!empty($obat)) {
                        TerapiObat::create([
                            'id_pemeriksaan' => $pemeriksaan->id_pemeriksaan,
                            'nama_obat' => $obat,
                            'aturan_pakai' => $request->aturan_pakai[$index] ?? '',
                            'jumlah_obat' => $request->jumlah_obat[$index] ?? 1,
                        ]);
                    }
                }
            }
            DB::commit();
            return redirect()->route('pemeriksaan.index')->with('success', 'Data Pemeriksaan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Pemeriksaan $pemeriksaan)
    {
        $pemeriksaan->load(['pasien', 'pemeriksa', 'terapiObats', 'diagnoses']);
        return view('pemeriksaan.show', compact('pemeriksaan'));
    }

    public function destroy(Pemeriksaan $pemeriksaan)
    {
        $pemeriksaan->delete();
        return redirect()->route('pemeriksaan.index')->with('success', 'Data Pemeriksaan berhasil dihapus.');
    }

    public function printPdf(Pemeriksaan $pemeriksaan)
    {
        $pemeriksaan->load(['pasien', 'pemeriksa', 'terapiObats', 'diagnoses']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pemeriksaan.pdf', compact('pemeriksaan'));
        return $pdf->download('Rekam_Medis_' . str_replace(' ', '_', $pemeriksaan->pasien->nama_lengkap ?? 'Unknown') . '_' . $pemeriksaan->tanggal_pemeriksaan->format('Ymd') . '.pdf');
    }
}
