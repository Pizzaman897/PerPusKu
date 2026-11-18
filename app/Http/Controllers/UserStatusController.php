<?php

namespace App\Http\Controllers;

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
                ->whereIn('status', ['pending', 'dipinjam'])
                ->latest()
                ->get(),
        ]);
    }
}
