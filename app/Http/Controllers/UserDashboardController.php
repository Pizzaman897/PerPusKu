<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    public function index(): View
    {
        return view('user.dashboard', [
            'title' => 'PerPusKu - Beranda',
            'books' => Buku::query()
                ->withExists([
                    'peminjaman as sedang_dipinjam' => fn ($query) => $query->whereNull('dikembalikan_pada'),
                ])
                ->latest()
                ->get(),
        ]);
    }
}
