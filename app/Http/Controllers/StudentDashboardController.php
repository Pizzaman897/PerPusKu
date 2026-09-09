<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $title = "PerPusKu - Dashboard Murid";

        $books = [
            [
                'id' => 1,
                'title' => 'Gajah Minum Air',
                'category' => 'Fiksi',
                'url gambar' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=640&q=80',
                'status' => 'ada',
            ],
            [
                'id' => 2,
                'title' => 'Belajar Pemrograman',
                'category' => 'Teknologi',
                'url gambar' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=640&q=80',
                'status' => 'tak ada',
            ],
        ];

        return view('Student.dashboard', [
            'title' => $title,
            'books' => $books,
        ]);
    }
}