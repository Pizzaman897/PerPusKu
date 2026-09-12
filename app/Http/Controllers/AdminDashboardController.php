<?php

namespace App\Http\Controllers;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalBuku = 120;
        $totalMurid = 220;
        $bukuDipinjam = 34;

        return view('Admin.DasborAdmin.index', compact(
            'totalBuku',
            'totalMurid',
            'bukuDipinjam'
        ));
    }
}