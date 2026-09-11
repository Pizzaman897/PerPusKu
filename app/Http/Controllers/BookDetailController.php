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
            'title' => 'Buku Kurikulum Merdeka_Matematika untuk SMA/SMK Kelas X',
            'category' => 'Pelajaran',
            'description' => 'Buku pelajaran umum, kitab suci, dan buku pelajaran agama dengan harga yang relatif terjangkau masyarakat umum, kitab suci, dan buku pelajaran agama dengan harga yang relatif terjangkau masyarakat',
            'status' => 'ada',
            'url gambar' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=900&q=80',
        ];

        return view('Student.book-detail', [
            'title' => $title,
            'book' => $book,
        ]);
    }

    public function pinjam(Request $request, string $id)
    {
        // TODO: ganti dengan proses simpan peminjaman yang sesungguhnya
        // (insert ke tabel peminjaman, update status buku, dsb)
        // begitu kamu sudah punya model/tabel untuk itu.

        return redirect()
            ->route('student.book.show', $id)
            ->with('success', 'Buku berhasil dipinjam.');
    }
}