<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $title = "PerPusKu - Dashboard Admin";

        $statistics = [
            'total_books' => 120,
            'total_students' => 85,
            'borrowed_books' => 23,
        ];

        return view('Admin.dashboard', [
            'title' => $title,
            'statistics' => $statistics,
        ]);
    }
}