<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $title = "PerPusKu - Kelola Buku";

        $books = [
            [
                'id' => 1,
                'title' => 'Gajah Minum Air',
                'category' => 'Fiksi',
                'status' => 'ada',
                'url gambar' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=640&q=80',
            ],
            [
                'id' => 2,
                'title' => 'Belajar Pemrograman',
                'category' => 'Teknologi',
                'status' => 'tak ada',
                'url gambar' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=640&q=80',
            ],
        ];

        return view('Admin.Book.index', [
            'title' => $title,
            'books' => $books,
        ]);
    }

    public function create()
    {
        return view('Admin.Book.create', [
            'title' => 'PerPusKu - Tambah Buku',
        ]);
    }

    public function store(Request $request)
    {
        return "Melakukan penambahan data buku";
    }

    public function show(string $id)
    {
        return view('Admin.Book.show', [
            'title' => 'PerPusKu - Detail Buku',
            'id' => $id,
        ]);
    }

    public function edit(string $id)
    {
        return view('Admin.Book.edit', [
            'title' => 'PerPusKu - Edit Buku',
            'id' => $id,
        ]);
    }

    public function update(Request $request, string $id)
    {
        return "Melakukan perubahan data buku dengan ID: {$id}";
    }

    public function destroy(string $id)
    {
        return "Menghapus data buku dengan ID: {$id}";
    }
}
