<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentStatusController extends Controller
{
    public function index(Request $request)
    {
        $title = "PerPusKu - Peminjaman Saya";

        // Data contoh. Nanti ganti dengan query dari database/model Peminjaman.
        $peminjaman = [
            [
                'id' => 1,
                'judul_buku' => 'Buku Kurikulum Merdeka_Matematika untuk SMA/SMK Kelas X',
                'url gambar' => asset('/images/buku-1.jpg'),
                'tanggal_pinjam' => '17 Agustus 2026',
                'batas_kembali' => '24 Agustus 2026',
                'status' => 'meminjam',
            ],
        ];

        return view('Student.status', [
            'title' => $title,
            'peminjaman' => $peminjaman,
        ]);
    }

    public function kembalikan(Request $request, string $id)
    {
        // TODO: ganti dengan proses update status peminjaman yang sesungguhnya
        // (set tanggal_kembali, ubah status buku jadi tersedia lagi, dsb)

        return redirect()
            ->route('student.history')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}