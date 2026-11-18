<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserStatusController extends Controller
{
    public function index(): View
    {
        $user = Auth::guard('web')->user();

        return view('user.status', [
            'title' => 'PerPusKu - Peminjaman Saya',
            'peminjaman' => $user->peminjaman()
                ->with('buku')
                ->latest()
                ->get(),
        ]);
    }

    public function kembalikan(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        abort_unless($peminjaman->user_id === Auth::guard('web')->id(), 404);

        if (! in_array($peminjaman->statusEfektif(), ['dipinjam', 'lewat_batas_waktu'], true)) {
            return back()->with('error', 'Peminjaman ini belum dapat dikembalikan.');
        }

        $dikembalikanPada = now();
        $peminjaman->dikembalikan_pada = $dikembalikanPada;
        $peminjaman->status = $dikembalikanPada->greaterThan($peminjaman->batas_pengembalian)
            ? 'terlambat'
            : 'dikembalikan';
        $peminjaman->save();

        return redirect()
            ->route('user.status')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}
