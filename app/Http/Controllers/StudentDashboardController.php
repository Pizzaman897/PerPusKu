<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $title = "PerPusKu - Beranda";

        // Data contoh. Nanti ganti dengan query dari database/model Buku.
        $books = [
            [
                'id' => 1,
                'title' => 'Matematika SMA/SMK Kelas X',
                'source' => 'Kemendikdasmen',
                'status' => 'ada',
                'url gambar' => 'https://images.unsplash.com/photo-1509228468518-180dd4864904?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'id' => 2,
                'title' => 'Pendidikan Pancasila dan Kewarganegaraan',
                'source' => 'Kemendikdasmen',
                'status' => 'ada',
                'url gambar' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'id' => 3,
                'title' => 'Pendidikan Agama Buddha dan Budi Pekerti',
                'source' => 'Kemendikdasmen',
                'status' => 'ada',
                'url gambar' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'id' => 4,
                'title' => 'Pendidikan Agama Kristen dan Budi Pekerti',
                'source' => 'Kemendikdasmen',
                'status' => 'ada',
                'url gambar' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'id' => 5,
                'title' => 'Cerdas Cergas Berbahasa dan Bersastra Indonesia',
                'source' => 'Kemendikdasmen',
                'status' => 'ada',
                'url gambar' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'id' => 6,
                'title' => 'Matematika SMA/SMK Kelas XI',
                'source' => 'Kemendikdasmen',
                'status' => 'ada',
                'url gambar' => 'https://images.unsplash.com/photo-1508921912186-1d1a45ebb3c1?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'id' => 7,
                'title' => 'Laskar Pelangi',
                'source' => 'Andrea Hirata',
                'status' => 'ada',
                'url gambar' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'id' => 8,
                'title' => 'IPS Ekonomi untuk SMA/MA Kelas X',
                'source' => 'Kemendikdasmen',
                'status' => 'ada',
                'url gambar' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=400&q=80',
            ],
        ];

        return view('Student.dashboard', [
            'title' => $title,
            'books' => $books,
        ]);
    }
}