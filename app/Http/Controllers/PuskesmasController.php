<?php

namespace App\Http\Controllers;

use App\Models\MasterPuskesmas;
use App\Models\MasterKecamatan;
use Illuminate\Http\Request;

class PuskesmasController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterPuskesmas::with('kecamatan.kabupaten.provinsi');
        
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_puskesmas', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_puskesmas', 'like', '%' . $request->search . '%');
        }
        
        $puskesmas = $query->paginate(10)->withQueryString();
        return view('puskesmas.index', compact('puskesmas'));
    }

    public function create()
    {
        $kecamatans = MasterKecamatan::all();
        $semuaKelurahans = \App\Models\MasterKelurahan::select('nama_kelurahan')->distinct()->orderBy('nama_kelurahan')->get();
        return view('puskesmas.create', compact('kecamatans', 'semuaKelurahans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_puskesmas' => 'required|string|unique:master_puskesmas',
            'nama_puskesmas' => 'required|string|max:255',
            'id_kecamatan' => 'required|exists:master_kecamatans,id_kecamatan',
            'alamat' => 'required|string',
            'no_telp' => 'nullable|string|max:20',
        ]);

        $puskesmas = MasterPuskesmas::create($validated);

        return redirect()->route('puskesmas.index')->with('success', 'Puskesmas berhasil ditambahkan.');
    }
    
    public function destroy(MasterPuskesmas $puskesma)
    {
        $puskesma->delete();
        return redirect()->route('puskesmas.index')->with('success', 'Puskesmas berhasil dihapus.');
    }

    public function edit(MasterPuskesmas $puskesma)
    {
        $kecamatans = MasterKecamatan::all();
        $puskesma->load('kelurahans');
        $semuaKelurahans = \App\Models\MasterKelurahan::select('nama_kelurahan')->distinct()->orderBy('nama_kelurahan')->get();
        return view('puskesmas.edit', compact('puskesma', 'kecamatans', 'semuaKelurahans'));
    }

    public function update(Request $request, MasterPuskesmas $puskesma)
    {
        $validated = $request->validate([
            'kode_puskesmas' => 'required|string|unique:master_puskesmas,kode_puskesmas,'.$puskesma->id_puskesmas.',id_puskesmas',
            'nama_puskesmas' => 'required|string|max:255',
            'id_kecamatan' => 'required|exists:master_kecamatans,id_kecamatan',
            'alamat' => 'required|string',
            'no_telp' => 'nullable|string|max:20',
        ]);

        $puskesma->update($validated);

        return redirect()->route('puskesmas.index')->with('success', 'Puskesmas berhasil diperbarui.');
    }

    public function getKelurahans(MasterPuskesmas $puskesma)
    {
        return response()->json($puskesma->kelurahans);
    }

    public function getAllKelurahans()
    {
        return response()->json(\App\Models\MasterKelurahan::select('nama_kelurahan')->distinct()->orderBy('nama_kelurahan')->get());
    }
}
