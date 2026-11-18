<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    public function index(): View
    {
        return view('admin.borrowings.index', [
            'title' => 'PerPusKu - Kelola Status',
            'borrowings' => Peminjaman::query()
                ->with(['user', 'buku'])
                ->latest()
                ->get(),
        ]);
    }

    public function update(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Status peminjaman sudah ditetapkan dan tidak dapat diubah lagi.');
        }

        $validated = $request->validate([
            'status' => ['sometimes', 'required', Rule::in(['pending', 'dipinjam'])],
            'batas_pengembalian' => ['sometimes', 'required', 'date', 'after:now'],
        ]);

        if ($validated === []) {
            return back()->with('error', 'Pilih status atau atur batas pengembalian terlebih dahulu.');
        }

        if (($validated['status'] ?? null) === 'dipinjam'
            && ! isset($validated['batas_pengembalian'])
            && $peminjaman->batas_pengembalian === null) {
            return back()->with('error', 'Atur batas pengembalian sebelum menyetujui peminjaman.');
        }

        $peminjaman->fill($validated)->save();

        return back()->with('success', 'Data peminjaman berhasil diperbarui.');
    }
}
