<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KelolaAdminController extends Controller
{
    /**
     * Tampilkan daftar admin.
     */
    public function index()
    {
        $admins = User::latest()->paginate(10);

        return view('Admin.Kelola-Admin.index', compact('admins'));
    }

    /**
     * Tampilkan form tambah admin.
     */
    public function create()
    {
        return view('Admin.Kelola-Admin.create');
    }

    /**
     * Tampilkan detail admin.
     */
    public function show(User $kelola_admin)
    {
        return view('Admin.Kelola-Admin.show', [
            'admin' => $kelola_admin,
        ]);
    }

    /**
     * Tampilkan form edit admin.
     */
    public function edit(User $kelola_admin)
    {
        return view('Admin.Kelola-Admin.edit', [
            'admin' => $kelola_admin,
        ]);
    }

    /**
     * Simpan admin baru.
     * Password tidak diminta lewat form — dibuatkan otomatis (acak)
     * lalu ditampilkan sekali di pesan sukses supaya bisa dibagikan ke admin terkait.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        ]);

        $generatedPassword = Str::password(10, symbols: false);

        try {
            User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($generatedPassword),
            ]);
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan admin: ' . $e->getMessage());
        }

        return redirect()
            ->route('admin.kelola-admin.index')
            ->with('success', "Admin berhasil ditambahkan. Password sementara: {$generatedPassword} (catat/salin sekarang, tidak ditampilkan lagi).");
    }

    /**
     * Perbarui data admin (nama & email saja, tanpa password).
     */
    public function update(Request $request, User $kelola_admin)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($kelola_admin->id),
            ],
        ]);

        try {
            $kelola_admin->update($validated);
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui admin: ' . $e->getMessage());
        }

        return redirect()
            ->route('admin.kelola-admin.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    /**
     * Hapus admin.
     */
    public function destroy(User $kelola_admin)
    {
        try {
            $kelola_admin->delete();
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus admin: ' . $e->getMessage());
        }

        return redirect()
            ->route('admin.kelola-admin.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}