<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $title = "PerPusKu - Kelola Murid";

        $students = [
            [
                'id' => 1,
                'name' => 'Andi',
                'email' => 'andi@gmail.com',
                'NIS' => '22100001',
            ],
            [
                'id' => 1,
                'name' => 'Andi',
                'email' => 'andi@gmail.com',
                'NIS' => '22100002',
            ],
        ];

        return view('Admin.Student.index', [
            'title' => $title,
            'students' => $students,
        ]);
    }

    public function create()
    {
        return view('Admin.Student.create', [
            'title' => 'PerPusKu - Tambah Murid',
        ]);
    }

    public function store(Request $request)
    {
        return "Melakukan penambahan data murid";
    }

    public function show(string $id)
    {
        return view('Admin.Student.show', [
            'title' => 'PerPusKu - Detail Murid',
            'id' => $id,
        ]);
    }

    public function edit(string $id)
    {
        return view('Admin.Student.edit', [
            'title' => 'PerPusKu - Edit Murid',
            'id' => $id,
        ]);
    }

    public function update(Request $request, string $id)
    {
        return "Melakukan perubahan data murid dengan ID: {$id}";
    }

    public function destroy(string $id)
    {
        return "Menghapus data murid dengan ID: {$id}";
    }
}