<?php

namespace App\Http\Controllers;

use App\Models\MasterKelompokGp;
use App\Models\MasterPuskesmas;
use Illuminate\Http\Request;

class MasterKelompokGpController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $query = MasterKelompokGp::with('puskesmas');
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_kelompok_gp', 'like', '%' . $request->search . '%');
        }

        $kelompokGps = $query->orderBy('nama_kelompok_gp')->paginate(15);
        $puskesmas = MasterPuskesmas::orderBy('nama_puskesmas')->get();
        
        return view('master-kelompok-gp.index', compact('kelompokGps', 'puskesmas'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $validated = $request->validate([
            'nama_kelompok_gp' => 'required|string|max:255|unique:master_kelompok_gps,nama_kelompok_gp',
            'id_puskesmas' => 'nullable|exists:master_puskesmas,id_puskesmas',
        ]);

        MasterKelompokGp::create($validated);

        return back()->with('success', 'Data Kelompok GP berhasil ditambahkan.');
    }

    public function update(Request $request, MasterKelompokGp $master_kelompok_gp)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $validated = $request->validate([
            'nama_kelompok_gp' => 'required|string|max:255|unique:master_kelompok_gps,nama_kelompok_gp,' . $master_kelompok_gp->id_kelompok_gp . ',id_kelompok_gp',
            'id_puskesmas' => 'nullable|exists:master_puskesmas,id_puskesmas',
        ]);

        $master_kelompok_gp->update($validated);

        return back()->with('success', 'Data Kelompok GP berhasil diperbarui.');
    }

    public function destroy(MasterKelompokGp $master_kelompok_gp)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $master_kelompok_gp->delete();

        return back()->with('success', 'Data Kelompok GP berhasil dihapus.');
    }
}
