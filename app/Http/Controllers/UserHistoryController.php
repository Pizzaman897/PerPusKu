<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserHistoryController extends Controller
{
    public function index(): View
    {
        $user = Auth::guard('web')->user();

        return view('user.history', [
            'title' => 'PerPusKu - Riwayat Peminjaman',
            'riwayat' => $user->peminjaman()
                ->with('buku')
                ->whereNotNull('dikembalikan_pada')
                ->latest('dikembalikan_pada')
                ->get(),
        ]);
    }
}
