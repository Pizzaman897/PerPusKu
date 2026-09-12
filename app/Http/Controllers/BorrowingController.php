<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        $title = "PerPusKu - Kelola Status";

        $borrowings = [
            [
                'id' => 1,
                'student' => 'Budi',
                'book_title' => 'Gajah Minum Air',
                'borrowed_at' => '01-09-2026',
                'returned_at' => '08-09-2026',
                'status' => 'pinjam',
            ],
            [
                'id' => 2,
                'student' => 'Andi',
                'book_title' => 'Belajar Pemrograman',
                'borrowed_at' => '01-09-2026',
                'returned_at' => '08-09-2026',
                'status' => 'pinjam',
            ],
        ];

        return view('Admin.Borrowing.index', [
            'title' => $title,
            'borrowings' => $borrowings,
        ]);
    }

    public function update(Request $request, string $id)
    {
        return "Mengubah status peminjaman dengan ID: {$id}";
    }
}
