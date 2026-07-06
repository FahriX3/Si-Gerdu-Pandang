<?php

namespace App\Http\Controllers;

use App\Models\MasterObat;
use Illuminate\Http\Request;

class MasterObatController extends Controller
{
    public function index(Request $request)
    {
        // Only allow admin_dinkes
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $query = MasterObat::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_obat', 'like', '%' . $request->search . '%');
        }

        $obats = $query->orderBy('nama_obat')->get();
        return view('master-obat.index', compact('obats'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
        ]);

        MasterObat::create($validated);

        return back()->with('success', 'Data Obat berhasil ditambahkan.');
    }

    public function update(Request $request, MasterObat $masterObat)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
        ]);

        $masterObat->update($validated);

        return back()->with('success', 'Data Obat berhasil diperbarui.');
    }

    public function destroy(MasterObat $masterObat)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $masterObat->delete();

        return back()->with('success', 'Data Obat berhasil dihapus.');
    }
}
