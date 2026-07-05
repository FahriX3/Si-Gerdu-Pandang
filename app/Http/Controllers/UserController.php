<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MasterPuskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('puskesmas')->paginate(10);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $puskesmas = MasterPuskesmas::all();
        return view('user.create', compact('puskesmas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin_dinkes,admin_puskesmas',
            'id_puskesmas' => 'nullable|exists:master_puskesmas,id_puskesmas'
        ]);

        if ($validated['role'] === 'admin_dinkes') {
            $validated['id_puskesmas'] = null;
        }

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function edit(User $user)
    {
        $puskesmas = MasterPuskesmas::all();
        return view('user.edit', compact('user', 'puskesmas'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin_dinkes,admin_puskesmas',
            'id_puskesmas' => 'nullable|exists:master_puskesmas,id_puskesmas'
        ]);

        if ($validated['role'] === 'admin_dinkes') {
            $validated['id_puskesmas'] = null;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }
}
