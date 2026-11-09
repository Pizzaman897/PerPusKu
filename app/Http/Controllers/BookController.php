<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * @var array<int, array{id: int, title: string, category: string, description: string, image_url: string, status: string, created_at: string, updated_at: string}>
     */
    private const BOOKS = [
        [
            'id' => 1,
            'title' => 'Gajah Minum Air',
            'category' => 'fiksi',
            'description' => 'Kisah ringan tentang petualangan dan persahabatan.',
            'image_url' => 'images/buku-1.jpg',
            'status' => 'tersedia',
            'created_at' => '2026-09-01 08:00:00',
            'updated_at' => '2026-09-01 08:00:00',
        ],
        [
            'id' => 2,
            'title' => 'Belajar Pemrograman',
            'category' => 'pelajaran',
            'description' => 'Pengantar dasar pemrograman untuk pembaca pemula.',
            'image_url' => 'images/buku-1.jpg',
            'status' => 'dipinjam',
            'created_at' => '2026-09-02 09:00:00',
            'updated_at' => '2026-09-06 11:30:00',
        ],
    ];

    public function index(): View
    {
        return view('admin.books.index', [
            'title' => 'PerPusKu - Kelola Buku',
            'books' => self::BOOKS,
        ]);
    }

    public function create(): View
    {
        return view('admin.books.create', [
            'title' => 'PerPusKu - Tambah Buku',
        ]);
    }

    public function store(Request $request): string
    {
        return 'Melakukan penambahan data buku';
    }

    public function show(string $id): View
    {
        return view('admin.books.show', [
            'title' => 'PerPusKu - Detail Buku',
            'book' => $this->findBook($id),
        ]);
    }

    public function edit(string $id): View
    {
        $book = (object) $this->findBook($id);

        return view('admin.books.edit', [
            'title' => 'PerPusKu - Edit Buku',
            'id' => $id,
            'buku' => $book,
        ]);
    }

    public function update(Request $request, string $id): string
    {
        return "Melakukan perubahan data buku dengan ID: {$id}";
    }

    public function destroy(string $id): string
    {
        return "Menghapus data buku dengan ID: {$id}";
    }

    /**
     * @return array{id: int, title: string, category: string, description: string, image_url: string, status: string, created_at: string, updated_at: string}
     */
    private function findBook(string $id): array
    {
        $book = collect(self::BOOKS)->firstWhere('id', (int) $id);

        abort_if($book === null, 404);

        return $book;
    }
}
