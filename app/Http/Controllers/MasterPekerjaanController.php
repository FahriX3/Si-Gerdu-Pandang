<?php

namespace App\Http\Controllers;

use App\Models\MasterPekerjaan;
use Illuminate\Http\Request;

class MasterPekerjaanController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $query = MasterPekerjaan::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_pekerjaan', 'like', '%' . $request->search . '%');
        }

        $pekerjaans = $query->orderBy('nama_pekerjaan')->get();
        return view('pekerjaan.index', compact('pekerjaans'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $validated = $request->validate([
            'nama_pekerjaan' => 'required|string|max:255|unique:master_pekerjaans,nama_pekerjaan',
        ]);

        MasterPekerjaan::create($validated);

        return back()->with('success', 'Data Pekerjaan berhasil ditambahkan.');
    }

    public function update(Request $request, MasterPekerjaan $master_pekerjaan)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $validated = $request->validate([
            'nama_pekerjaan' => 'required|string|max:255|unique:master_pekerjaans,nama_pekerjaan,' . $master_pekerjaan->id_pekerjaan . ',id_pekerjaan',
        ]);

        $master_pekerjaan->update($validated);

        return back()->with('success', 'Data Pekerjaan berhasil diperbarui.');
    }

    public function destroy(MasterPekerjaan $master_pekerjaan)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $master_pekerjaan->delete();

        return back()->with('success', 'Data Pekerjaan berhasil dihapus.');
    }
}
