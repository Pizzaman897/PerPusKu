<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookDetailController extends Controller
{
    public function show(string $id)
    {
        $title = "PerPusKu - Detail Buku";

        $book = [
            'id' => $id,
            'title' => 'Gajah Minum Air',
            'category' => 'Fiksi',
            'description' => 'Deskripsi buku akan ditampilkan di sini.',
            'status' => 'ada',
            'url gambar' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=900&q=80',
        ];

        return view('Student.book-detail', [
            'title' => $title,
            'book' => $book,
        ]);
    }
}