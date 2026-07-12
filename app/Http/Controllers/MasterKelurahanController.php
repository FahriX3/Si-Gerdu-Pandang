<?php

namespace App\Http\Controllers;

use App\Models\MasterKelurahan;
use App\Models\MasterPuskesmas;
use Illuminate\Http\Request;

class MasterKelurahanController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $query = MasterKelurahan::with('puskesmas');
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_kelurahan', 'like', '%' . $request->search . '%')
                  ->orWhereHas('puskesmas', function($q) use ($request) {
                      $q->where('nama_puskesmas', 'like', '%' . $request->search . '%');
                  });
        }

        $kelurahans = $query->join('master_puskesmas', 'master_kelurahans.id_puskesmas', '=', 'master_puskesmas.id_puskesmas')
                            ->orderBy('master_puskesmas.nama_puskesmas')
                            ->orderBy('master_kelurahans.nama_kelurahan')
                            ->select('master_kelurahans.*')
                            ->get()
                            ->groupBy('puskesmas.nama_puskesmas');

        $puskesmasList = MasterPuskesmas::orderBy('nama_puskesmas')->get();
        
        return view('kelurahan.index', compact('kelurahans', 'puskesmasList'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $validated = $request->validate([
            'id_puskesmas' => 'required|exists:master_puskesmas,id_puskesmas',
            'nama_kelurahan' => 'required|string|max:255',
        ]);

        MasterKelurahan::create($validated);

        return back()->with('success', 'Data Kalurahan berhasil ditambahkan.');
    }

    public function update(Request $request, MasterKelurahan $master_kelurahan)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $validated = $request->validate([
            'id_puskesmas' => 'required|exists:master_puskesmas,id_puskesmas',
            'nama_kelurahan' => 'required|string|max:255',
        ]);

        $master_kelurahan->update($validated);

        return back()->with('success', 'Data Kalurahan berhasil diperbarui.');
    }

    public function destroy(MasterKelurahan $master_kelurahan)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $master_kelurahan->delete();

        return back()->with('success', 'Data Kalurahan berhasil dihapus.');
    }
}
