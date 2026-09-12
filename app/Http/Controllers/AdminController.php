<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $title = "PerPusKu - Kelola Admin";

        $admins = [
            [
                'id' => 1,
                'name' => 'Admin Utama',
                'email' => 'admin@perpusku.com',
            ],
            [
                'id' => 2,
                'name' => 'Admin Perpustakaan',
                'email' => 'perpus@perpusku.com',
            ],
        ];

    }

    public function create()
    {
        return view('Admin.Admin.create', [
            'title' => 'PerPusKu - Tambah Admin',
        ]);
    }

    public function store(Request $request)
    {
        return "Melakukan penambahan data admin";
    }

    public function show(string $id)
    {
        return view('Admin.Admin.show', [
            'title' => 'PerPusKu - Detail Admin',
            'id' => $id,
        ]);
    }

    public function edit(string $id)
    {
        return view('Admin.Admin.edit', [
            'title' => 'PerPusKu - Edit Admin',
            'id' => $id,
        ]);
    }

    public function update(Request $request, string $id)
    {
        return "Melakukan perubahan data admin dengan ID: {$id}";
    }

    public function destroy(string $id)
    {
        return "Menghapus data admin dengan ID: {$id}";
    }
}