<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Buku;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalBuku = Buku::count();
        $totalUsers = User::count();
        $totalAdmin = Admin::count();

        return view('admin.dashboard.index', compact(
            'totalBuku',
            'totalUsers',
            'totalAdmin'
        ));
    }
}
