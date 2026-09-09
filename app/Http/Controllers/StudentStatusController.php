<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentStatusController extends Controller
{
    public function index()
    {
        $title = "PerPusKu - Status Peminjaman";

        $borrowings = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'book' => 'Gajah Minum Air',
                'borrow_date' => '01-09-2026',
                'return_date' => '08-09-2026',
                'status' => 'Sedang Dipinjam',
            ],
        ];

        return view('Student.status', [
            'title' => $title,
            'borrowings' => $borrowings,
        ]);
    }
}