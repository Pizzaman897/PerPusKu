<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalBuku = 120;
        $totalMurid = 220;
        $bukuDipinjam = 34;

        return view('admin.dashboard.index', compact(
            'totalBuku',
            'totalMurid',
            'bukuDipinjam'
        ));
    }
}
