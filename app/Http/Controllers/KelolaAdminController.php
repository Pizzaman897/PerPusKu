<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KelolaAdminController extends Controller
{
    /**
     * Tampilkan daftar admin.
     */
    public function index()
    {
        $admins = User::latest()->paginate(10);

        return view('admin.kelola-admin.index', compact('admins'));
    }

    /**
     * Simpan admin baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.kelola-admin.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * Perbarui data admin.
     */
    public function update(Request $request, User $kelola_admin)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($kelola_admin->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $kelola_admin->name  = $validated['name'];
        $kelola_admin->email = $validated['email'];

        if (!empty($validated['password'])) {
            $kelola_admin->password = Hash::make($validated['password']);
        }

        $kelola_admin->save();

        return redirect()
            ->route('admin.kelola-admin.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    /**
     * Hapus admin.
     */
    public function destroy(User $kelola_admin)
    {
        $kelola_admin->delete();

        return redirect()
            ->route('admin.kelola-admin.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}