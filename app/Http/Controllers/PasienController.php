<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\MasterPuskesmas;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $query = Pasien::with('puskesmas');
        
        $kelurahans = [];
        if (auth()->user()->role !== 'admin_dinkes') {
            $query->where('id_puskesmas', auth()->user()->id_puskesmas);
            $kelurahans = \App\Models\MasterKelurahan::where('id_puskesmas', auth()->user()->id_puskesmas)->orderBy('nama_kelurahan')->get();
        } elseif ($request->filled('id_puskesmas')) {
            $query->where('id_puskesmas', $request->id_puskesmas);
        }

        if (auth()->user()->role === 'admin_dinkes') {
            $kelurahans = \App\Models\MasterKelurahan::select('nama_kelurahan')->distinct()->orderBy('nama_kelurahan')->get();
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        }
        $pasiens = $query->orderBy('created_at', 'desc')->paginate(10);
        $puskesmas = auth()->user()->role === 'admin_dinkes' ? MasterPuskesmas::all() : [];
        return view('pasien.index', compact('pasiens', 'puskesmas', 'kelurahans'));
    }

    public function create()
    {
        $puskesmas = [];
        $kelurahans = [];
        if (auth()->user()->role === 'admin_dinkes') {
            $puskesmas = MasterPuskesmas::all();
        } else {
            $kelurahans = \App\Models\MasterKelurahan::where('id_puskesmas', auth()->user()->id_puskesmas)->get();
        }
        return view('pasien.create', compact('puskesmas', 'kelurahans'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nik' => 'required|string|size:16|unique:pasiens,nik',
            'no_kk' => 'required|string|size:16',
            'nama_kepala_keluarga' => 'required|string|max:255',
            'status_peserta' => 'required|in:Aktif,Meninggal,Pindah Domisili,Non-Aktif',
            'tanggal_meninggal' => 'nullable|date',
            'kalurahan' => 'required|string|max:255',
            'dukuh' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'no_hp' => 'nullable|string|max:20',
            'no_jkn' => 'nullable|string|max:50',
            'no_rm' => 'nullable|string|max:50',
            'tanggal_awal_terdaftar' => 'required|date',
            'jenis_prolanis' => 'required|in:HT,DM',
            'status_peserta_prb' => 'nullable|in:HT,DM,Penyakit Jantung,PPOK,Asma',
            'riwayat_hipertensi_keluarga' => 'required|in:Ya,Tidak,Tidak Tahu',
            'jenis_pekerjaan' => 'required|in:PNS,TNI/Polri,Swasta,Wiraswasta,Petani/Nelayan,Tidak Kerja',
            'status_merokok' => 'required|in:Ya,Tidak',
        ];

        if (auth()->user()->role === 'admin_dinkes') {
            $rules['id_puskesmas'] = 'required|exists:master_puskesmas,id_puskesmas';
        }

        $validated = $request->validate($rules);

        if (auth()->user()->role !== 'admin_dinkes') {
            $validated['id_puskesmas'] = auth()->user()->id_puskesmas;
        }

        Pasien::create($validated);

        return redirect()->route('pasien.index')->with('success', 'Data Pasien berhasil ditambahkan.');
    }

    public function show(Pasien $pasien)
    {
        $pasien->load(['pemeriksaans' => function($q) {
            $q->orderBy('tanggal_pemeriksaan', 'desc');
        }, 'pemeriksaans.terapiObats', 'pemeriksaans.pemeriksa']);
        
        return view('pasien.show', compact('pasien'));
    }

    public function edit(Pasien $pasien)
    {
        $puskesmas = [];
        if (auth()->user()->role === 'admin_dinkes') {
            $puskesmas = MasterPuskesmas::all();
        }
        return view('pasien.edit', compact('pasien', 'puskesmas'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nik' => 'required|string|size:16|unique:pasiens,nik,'.$pasien->id_pasien.',id_pasien',
            'no_kk' => 'required|string|size:16',
            'nama_kepala_keluarga' => 'required|string|max:255',
            'status_peserta' => 'required|in:Aktif,Meninggal,Pindah Domisili,Non-Aktif',
            'tanggal_meninggal' => 'nullable|date',
            'kalurahan' => 'required|string|max:255',
            'dukuh' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'no_hp' => 'nullable|string|max:20',
            'no_jkn' => 'nullable|string|max:50',
            'no_rm' => 'nullable|string|max:50',
            'tanggal_awal_terdaftar' => 'required|date',
            'jenis_prolanis' => 'required|in:HT,DM',
            'status_peserta_prb' => 'nullable|in:HT,DM,Penyakit Jantung,PPOK,Asma',
            'riwayat_hipertensi_keluarga' => 'required|in:Ya,Tidak,Tidak Tahu',
            'jenis_pekerjaan' => 'required|in:PNS,TNI/Polri,Swasta,Wiraswasta,Petani/Nelayan,Tidak Kerja',
            'status_merokok' => 'required|in:Ya,Tidak',
        ];

        if (auth()->user()->role === 'admin_dinkes') {
            $rules['id_puskesmas'] = 'required|exists:master_puskesmas,id_puskesmas';
        }

        $validated = $request->validate($rules);

        $pasien->update($validated);

        return redirect()->route('pasien.index')->with('success', 'Data Pasien berhasil diperbarui.');
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('pasien.index')->with('success', 'Data Pasien berhasil dihapus.');
    }

    public function printPdf(Pasien $pasien)
    {
        $pasien->load(['pemeriksaans' => function($q) {
            $q->orderBy('tanggal_pemeriksaan', 'desc');
        }, 'pemeriksaans.terapiObats', 'pemeriksaans.pemeriksa', 'puskesmas']);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pasien.pdf', compact('pasien'));
        return $pdf->download('Profil_Pasien_' . str_replace(' ', '_', $pasien->nama_lengkap) . '.pdf');
    }

    public function exportRegisterPdf(Request $request)
    {
        $query = Pasien::with('puskesmas');
        
        $filterTexts = [];
        
        // Cek apakah mode tanpa filter aktif
        $noFilter = $request->has('semua_data') && $request->semua_data == '1';
        
        // Filter based on role
        if (auth()->user()->role !== 'admin_dinkes') {
            $query->where('id_puskesmas', auth()->user()->id_puskesmas);
        } elseif (!$noFilter && $request->filled('id_puskesmas')) {
            $query->where('id_puskesmas', $request->id_puskesmas);
        }

        if (!$noFilter) {
            // Date Filter
            if ($request->filled('tanggal_awal')) {
                $query->whereDate('tanggal_awal_terdaftar', '>=', $request->tanggal_awal);
            }
            if ($request->filled('tanggal_akhir')) {
                $query->whereDate('tanggal_awal_terdaftar', '<=', $request->tanggal_akhir);
            }
            if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
                $filterTexts[] = "Periode: " . $request->tanggal_awal . " s/d " . $request->tanggal_akhir;
            }
    
            // Kalurahan Filter
            if ($request->filled('kalurahan')) {
                $query->where('kalurahan', 'like', '%' . $request->kalurahan . '%');
                $filterTexts[] = "Kalurahan: " . strtoupper($request->kalurahan);
            }
        }

        $pasiens = $query->orderBy('tanggal_awal_terdaftar', 'asc')->get();

        $puskesmasName = "SEMUA PUSKESMAS";
        if (auth()->user()->role !== 'admin_dinkes') {
            $puskesmasName = auth()->user()->puskesmas->nama_puskesmas ?? "SEMUA PUSKESMAS";
        } elseif (!$noFilter && $request->filled('id_puskesmas')) {
            $pusk = MasterPuskesmas::find($request->id_puskesmas);
            if ($pusk) {
                $puskesmasName = $pusk->nama_puskesmas;
                $filterTexts[] = "Puskesmas: " . $pusk->nama_puskesmas;
            }
        }

        $kalurahanName = (!$noFilter && $request->filled('kalurahan')) ? strtoupper($request->kalurahan) : 'SEMUA KALURAHAN';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pasien.pdf_register', [
            'pasiens' => $pasiens,
            'puskesmasName' => strtoupper($puskesmasName),
            'kalurahanName' => $kalurahanName,
            'filters' => $filterTexts,
            'user' => auth()->user()
        ]);
        
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download("register_peserta_" . date('Ymd_His') . ".pdf");
    }
}
