<?php

namespace App\Http\Controllers;

use App\Models\MasterDukuh;
use Illuminate\Http\Request;

class MasterDukuhController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $query = MasterDukuh::with('kelurahan');
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_dukuh', 'like', '%' . $request->search . '%')
                  ->orWhereHas('kelurahan', function($q) use ($request) {
                      $q->where('nama_kelurahan', 'like', '%' . $request->search . '%');
                  });
        }

        $dukuhs = $query->join('master_kelurahans', 'master_dukuhs.id_kelurahan', '=', 'master_kelurahans.id_kelurahan')
                        ->orderBy('master_kelurahans.nama_kelurahan')
                        ->orderBy('master_dukuhs.nama_dukuh')
                        ->select('master_dukuhs.*')
                        ->get()
                        ->groupBy(function($item) {
                            return $item->kelurahan ? $item->kelurahan->nama_kelurahan : 'Tanpa Kalurahan';
                        });

        $kelurahans = \App\Models\MasterKelurahan::orderBy('nama_kelurahan')->get();
        
        return view('dukuh.index', compact('dukuhs', 'kelurahans'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $validated = $request->validate([
            'id_kelurahan' => 'required|exists:master_kelurahans,id_kelurahan',
            'nama_dukuh' => 'required|string|max:255',
        ]);

        MasterDukuh::create($validated);

        return back()->with('success', 'Data Dukuh berhasil ditambahkan.');
    }

    public function update(Request $request, MasterDukuh $master_dukuh)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $validated = $request->validate([
            'id_kelurahan' => 'required|exists:master_kelurahans,id_kelurahan',
            'nama_dukuh' => 'required|string|max:255',
        ]);

        $master_dukuh->update($validated);

        return back()->with('success', 'Data Dukuh berhasil diperbarui.');
    }

    public function destroy(MasterDukuh $master_dukuh)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $master_dukuh->delete();

        return back()->with('success', 'Data Dukuh berhasil dihapus.');
    }
}
