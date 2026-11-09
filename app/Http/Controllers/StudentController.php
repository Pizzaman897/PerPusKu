<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * @var array<int, array{id: int, name: string, email: string, nis: string, created_at: string, updated_at: string}>
     */
    private const STUDENTS = [
        [
            'id' => 1,
            'name' => 'Andi Pratama',
            'email' => 'andi.pratama@example.com',
            'nis' => '221001',
            'created_at' => '2026-09-01 08:00:00',
            'updated_at' => '2026-09-01 08:00:00',
        ],
        [
            'id' => 2,
            'name' => 'Siti Rahmawati',
            'email' => 'siti.rahmawati@example.com',
            'nis' => '221002',
            'created_at' => '2026-09-03 09:30:00',
            'updated_at' => '2026-09-05 10:15:00',
        ],
    ];

    public function index(): View
    {
        return view('admin.students.index', [
            'title' => 'PerPusKu - Kelola Murid',
            'students' => self::STUDENTS,
        ]);
    }

    public function create(): View
    {
        return view('admin.students.create', [
            'title' => 'PerPusKu - Tambah Murid',
        ]);
    }

    public function store(Request $request): string
    {
        return 'Melakukan penambahan data murid';
    }

    public function show(string $id): View
    {
        return view('admin.students.show', [
            'title' => 'PerPusKu - Detail Murid',
            'student' => $this->findStudent($id),
        ]);
    }

    public function edit(string $id): View
    {
        return view('admin.students.edit', [
            'title' => 'PerPusKu - Edit Murid',
            'student' => $this->findStudent($id),
        ]);
    }

    public function update(Request $request, string $id): string
    {
        return "Melakukan perubahan data murid dengan ID: {$id}";
    }

    public function destroy(string $id): string
    {
        return "Menghapus data murid dengan ID: {$id}";
    }

    /**
     * @return array{id: int, name: string, email: string, nis: string, created_at: string, updated_at: string}
     */
    private function findStudent(string $id): array
    {
        $student = collect(self::STUDENTS)->firstWhere('id', (int) $id);

        abort_if($student === null, 404);

        return $student;
    }
}
