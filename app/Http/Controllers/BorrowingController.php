<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        $title = 'PerPusKu - Kelola Status';

        $borrowings = [
            [
                'id' => 1,
                'student_id' => 1,
                'book_id' => 1,
                'student' => 'Budi',
                'book_title' => 'Gajah Minum Air',
                'borrowed_at' => '01-09-2026',
                'due_at' => '08-09-2026',
                'returned_at' => '08-09-2026',
                'created_at' => '01-09-2026 08:00',
                'updated_at' => '08-09-2026 10:00',
                'status' => 'dikembalikan',
            ],
            [
                'id' => 2,
                'student_id' => 2,
                'book_id' => 2,
                'student' => 'Andi',
                'book_title' => 'Belajar Pemrograman',
                'borrowed_at' => '01-09-2026',
                'due_at' => '08-09-2026',
                'returned_at' => null,
                'created_at' => '01-09-2026 08:15',
                'updated_at' => '01-09-2026 08:15',
                'status' => 'terlambat',
            ],
        ];

        return view('admin.borrowings.index', [
            'title' => $title,
            'borrowings' => $borrowings,
        ]);
    }

    public function update(Request $request, string $id)
    {
        return "Mengubah status peminjaman dengan ID: {$id}";
    }
}
