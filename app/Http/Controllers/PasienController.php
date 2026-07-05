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
        
        if (auth()->user()->role !== 'admin_dinkes') {
            $query->where('id_puskesmas', auth()->user()->id_puskesmas);
        } elseif ($request->filled('id_puskesmas')) {
            $query->where('id_puskesmas', $request->id_puskesmas);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        }
        $pasiens = $query->orderBy('created_at', 'desc')->paginate(10);
        $puskesmas = auth()->user()->role === 'admin_dinkes' ? MasterPuskesmas::all() : [];
        return view('pasien.index', compact('pasiens', 'puskesmas'));
    }

    public function create()
    {
        $puskesmas = [];
        if (auth()->user()->role === 'admin_dinkes') {
            $puskesmas = MasterPuskesmas::all();
        }
        return view('pasien.create', compact('puskesmas'));
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
            'tanggal_awal_terdaftar' => 'required|date',
            'jenis_prolanis' => 'required|string|max:50',
            'riwayat_hipertensi_keluarga' => 'required|in:Ya,Tidak,Tidak Tahu',
            'jenis_pekerjaan' => 'required|string|max:255',
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
            'tanggal_awal_terdaftar' => 'required|date',
            'jenis_prolanis' => 'required|string|max:50',
            'riwayat_hipertensi_keluarga' => 'required|in:Ya,Tidak,Tidak Tahu',
            'jenis_pekerjaan' => 'required|string|max:255',
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
}
