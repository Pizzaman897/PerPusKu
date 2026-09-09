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
                'name' => 'Gajah minum air',
                'book' => 'Fiksi',
                'borrow_date' => 'Gajah minum air di sungai',
                'return_date' => 'URL NYA',
                'status' => 'Tersedia',
            ],
            [
                'id' => 2,
                'name' => 'Andi',
                'book' => 'Belajar Pemrograman',
                'borrow_date' => '01-09-2026',
                'return_date' => '08-09-2026',
                'status' => 'Menunggu Konfirmasi',
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
