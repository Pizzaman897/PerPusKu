<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminManagementController extends Controller
{
    /**
     * Tampilkan daftar admin.
     */
    public function index(): View
    {
        $admins = Admin::latest()->paginate(10);

        return view('admin.administrators.index', compact('admins'));
    }

    /**
     * Tampilkan form tambah admin.
     */
    public function create(): View
    {
        return view('admin.administrators.create');
    }

    /**
     * Tampilkan detail admin.
     */
    public function show(Admin $admin): View
    {
        return view('admin.administrators.show', [
            'admin' => $admin,
        ]);
    }

    /**
     * Tampilkan form edit admin.
     */
    public function edit(Admin $admin): View
    {
        return view('admin.administrators.edit', [
            'admin' => $admin,
        ]);
    }

    /**
     * Simpan admin baru.
     * Password tidak diminta lewat form — dibuatkan otomatis (acak)
     * lalu ditampilkan sekali di pesan sukses supaya bisa dibagikan ke admin terkait.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email'],
        ]);

        $generatedPassword = Str::password(10, symbols: false);

        try {
            Admin::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($generatedPassword),
            ]);
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan admin: '.$e->getMessage());
        }

        return redirect()
            ->route('admin.kelola-admin.index')
            ->with('success', "Admin berhasil ditambahkan. Password sementara: {$generatedPassword} (catat/salin sekarang, tidak ditampilkan lagi).");
    }

    /**
     * Perbarui data admin (nama & email saja, tanpa password).
     */
    public function update(Request $request, Admin $admin): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('admins', 'email')->ignore($admin->id),
            ],
        ]);

        try {
            $admin->update($validated);
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui admin: '.$e->getMessage());
        }

        return redirect()
            ->route('admin.kelola-admin.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    /**
     * Hapus admin.
     */
    public function destroy(Admin $admin): RedirectResponse
    {
        try {
            $admin->delete();
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus admin: '.$e->getMessage());
        }

        return redirect()
            ->route('admin.kelola-admin.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}
