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
        if (! in_array($peminjaman->status, ['pending', 'dipinjam'], true)) {
            return back()->with('error', 'Status peminjaman sudah ditetapkan dan tidak dapat diubah lagi.');
        }

        $validated = $request->validated();

        if ($peminjaman->status === 'dipinjam' && ($validated['status'] ?? null) === 'pending') {
            return back()->with('error', 'Peminjaman yang sedang berlangsung tidak dapat dikembalikan ke status Pending.');
        }

        if (isset($validated['batas_pengembalian']) && $peminjaman->status !== 'pending') {
            return back()->with('error', 'Batas pengembalian hanya dapat diubah saat status masih Pending.');
        }

        if ($validated === []) {
            return back()->with('error', 'Pilih status atau atur batas pengembalian terlebih dahulu.');
        }

        $statusBaru = $validated['status'] ?? null;

        if ($peminjaman->status === 'pending' && in_array($statusBaru, ['dikembalikan', 'terlambat'], true)) {
            return back()->with('error', 'Peminjaman harus disetujui sebelum dapat diselesaikan.');
        }

        if ($peminjaman->status === 'dipinjam' && $statusBaru !== null) {
            $statusEfektif = $peminjaman->statusEfektif();
            $statusSelesaiYangDiizinkan = $statusEfektif === 'lewat_batas_waktu'
                ? 'terlambat'
                : 'dikembalikan';

            if ($statusBaru !== $statusSelesaiYangDiizinkan) {
                $pesan = $statusEfektif === 'lewat_batas_waktu'
                    ? 'Batas pengembalian sudah lewat; status hanya dapat diubah menjadi Terlambat.'
                    : 'Batas pengembalian belum lewat; status hanya dapat diubah menjadi Dikembalikan.';

                return back()->with('error', $pesan);
            }
        }

        if (($validated['status'] ?? null) === 'dipinjam'
            && ! isset($validated['batas_pengembalian'])
            && $peminjaman->batas_pengembalian === null) {
            return back()->with('error', 'Atur batas pengembalian sebelum menyetujui peminjaman.');
        }

        if (($validated['status'] ?? null) === 'dipinjam'
            && ! isset($validated['batas_pengembalian'])
            && $peminjaman->batas_pengembalian?->isPast()) {
            return back()->with('error', 'Batas pengembalian sudah lewat; atur ulang sebelum menyetujui peminjaman.');
        }

        if (in_array($validated['status'] ?? null, ['dikembalikan', 'terlambat'], true)) {
            $validated['dikembalikan_pada'] = now();
        }

        $peminjaman->fill($validated)->save();

        return back()->with('success', 'Data peminjaman berhasil diperbarui.');
    }
}
