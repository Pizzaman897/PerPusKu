<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentHistoryController extends Controller
{
    public function index()
    {
        $title = "PerPusKu - History Peminjaman";

        $history = [
            [
                'id' => 1,
                'book' => 'Belajar Pemrograman',
                'borrow_date' => '01-08-2026',
                'return_date' => '08-08-2026',
                'status' => 'Dikembalikan',
                'url gambar' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=640&q=80',
            ],
            [
                'id' => 2,
                'book' => 'Dasar Jaringan Komputer',
                'borrow_date' => '10-08-2026',
                'return_date' => '17-08-2026',
                'status' => 'Dikembalikan',
                'url gambar' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=640&q=80',
            ],
        ];

        return view('Student.history', [
            'title' => $title,
            'history' => $history,
        ]);
    }
}