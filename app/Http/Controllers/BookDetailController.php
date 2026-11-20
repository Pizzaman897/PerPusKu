<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookDetailController extends Controller
{
    public function show(Buku $buku): View
    {
        abort_unless($buku->aktif, 404);

        $peminjamanAktif = $buku->peminjaman()
            ->whereNull('dikembalikan_pada')
            ->latest()
            ->first();

        return view('user.book-detail', [
            'title' => 'PerPusKu - Detail Buku',
            'book' => $buku,
            'peminjamanAktif' => $peminjamanAktif,
        ]);
    }

    public function pinjam(Request $request, Buku $buku): RedirectResponse
    {
        abort_unless($buku->aktif, 404);

        if ($buku->peminjaman()->whereNull('dikembalikan_pada')->exists()) {
            return back()->with('error', 'Buku sedang menunggu persetujuan atau sedang dipinjam.');
        }

        Peminjaman::create([
            'user_id' => Auth::guard('web')->id(),
            'buku_id' => $buku->id,
            'dipinjam_pada' => now(),
            'status' => 'pending',
        ]);

        return redirect()
            ->route('user.status')
            ->with('success', 'Permintaan peminjaman dikirim dan menunggu persetujuan admin.');
    }
}
