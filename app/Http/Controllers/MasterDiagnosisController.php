<?php

namespace App\Http\Controllers;

use App\Models\MasterDiagnosis;
use Illuminate\Http\Request;

class MasterDiagnosisController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $query = MasterDiagnosis::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_diagnosis', 'like', '%' . $request->search . '%');
        }

        $diagnoses = $query->orderBy('nama_diagnosis')->paginate(15);
        
        return view('master-diagnosis.index', compact('diagnoses'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $validated = $request->validate([
            'nama_diagnosis' => 'required|string|max:255|unique:master_diagnoses,nama_diagnosis',
        ]);

        MasterDiagnosis::create($validated);

        return back()->with('success', 'Data Diagnosis berhasil ditambahkan.');
    }

    public function update(Request $request, MasterDiagnosis $master_diagnosis)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $validated = $request->validate([
            'nama_diagnosis' => 'required|string|max:255|unique:master_diagnoses,nama_diagnosis,' . $master_diagnosis->id_diagnosis . ',id_diagnosis',
        ]);

        $master_diagnosis->update($validated);

        return back()->with('success', 'Data Diagnosis berhasil diperbarui.');
    }

    public function destroy(MasterDiagnosis $master_diagnosis)
    {
        if (auth()->user()->role !== 'admin_dinkes') {
            abort(403);
        }

        $master_diagnosis->delete();

        return back()->with('success', 'Data Diagnosis berhasil dihapus.');
    }
}
