<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'title' => 'PerPusKu - Kelola User',
            'users' => User::query()->latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'title' => 'PerPusKu - Tambah User',
        ]);
    }

    public function store(Request $request): string
    {
        return 'Melakukan penambahan data user';
    }

    public function show(User $user): View
    {
        return view('admin.users.show', [
            'title' => 'PerPusKu - Detail User',
            'user' => $user,
        ]);
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'title' => 'PerPusKu - Edit User',
            'user' => $user,
        ]);
    }

    public function update(Request $request, string $id): string
    {
        return "Melakukan perubahan data user dengan ID: {$id}";
    }

    public function destroy(User $user): RedirectResponse
    {
        if (Schema::hasColumn('peminjaman', 'user_id') && $user->peminjaman()->exists()) {
            return back()
                ->with('error', 'User tidak dapat dihapus karena masih memiliki riwayat peminjaman.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
