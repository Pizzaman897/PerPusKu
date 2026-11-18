<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBorrowingRequest;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
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

    public function update(UpdateBorrowingRequest $request, Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Status peminjaman sudah ditetapkan dan tidak dapat diubah lagi.');
        }

        $validated = $request->validated();

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
