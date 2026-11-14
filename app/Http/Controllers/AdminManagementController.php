<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Admin::create($validated);

        return redirect()
            ->route('admin.kelola-admin.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    public function update(Request $request, Admin $admin): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('admins', 'email')->ignore($admin->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $admin->update($validated);

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
