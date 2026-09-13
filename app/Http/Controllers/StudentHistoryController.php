<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentHistoryController extends Controller
{
    public function index(Request $request)
    {
        $title = "PerPusKu - Riwayat Peminjaman";

        // Data contoh. Nanti ganti dengan query dari database/model Peminjaman
        // (yang statusnya sudah "dikembalikan").
        $riwayat = [
            [
                'id' => 1,
                'judul_buku' => 'Buku Kurikulum Merdeka_Matematika untuk SMA/SMK Kelas X',
                'url gambar' => asset('/images/buku-1.jpg'),
                'tanggal_pinjam' => '17 Agustus 2026',
                'tanggal_kembali' => '20 Agustus 2026',
                'status' => 'tepat_waktu',
            ],
            [
                'id' => 2,
                'judul_buku' => 'Laskar Pelangi',
                'url gambar' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=400&q=80',
                'tanggal_pinjam' => '1 Agustus 2026',
                'tanggal_kembali' => '10 Agustus 2026',
                'status' => 'terlambat',
            ],
        ];

        return view('Student.history', [
            'title' => $title,
            'riwayat' => $riwayat,
        ]);
    }
}