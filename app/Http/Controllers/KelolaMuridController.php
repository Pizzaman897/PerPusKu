<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class KelolaMuridController extends Controller
{
    /**
     * Ambil data murid dari session.
     * Sementara belum pakai database — data disimpan di session dulu.
     */
    private function getStudents(): array
    {
        if (! Session::has('students')) {
            Session::put('students', [
                1 => [
                    'id'            => 1,
                    'name'          => 'Andi',
                    'email'         => 'andi@gmail.com',
                    'nis'           => '2610001',
                    'status_pinjam' => 'tidak_dipinjam',
                ],
                2 => [
                    'id'            => 2,
                    'name'          => 'Budi',
                    'email'         => 'budi@gmail.com',
                    'nis'           => '2610002',
                    'status_pinjam' => 'dipinjam',
                ],
            ]);
            Session::put('students_next_id', 3);
        }

        return Session::get('students');
    }

    /**
     * Tampilkan daftar murid.
     */
    public function index()
    {
        $students = $this->getStudents();

        return view('Admin.Kelola-Murid.index', compact('students'));
    }

    /**
     * Tampilkan form tambah murid.
     */
    public function create()
    {
        return view('Admin.Kelola-Murid.create');
    }

    /**
     * Tampilkan detail murid.
     */
    public function show(string $kelola_murid)
    {
        $students = $this->getStudents();

        abort_unless(isset($students[$kelola_murid]), 404);

        return view('Admin.Kelola-Murid.show', [
            'student' => $students[$kelola_murid],
        ]);
    }

    /**
     * Tampilkan form edit murid.
     */
    public function edit(string $kelola_murid)
    {
        $students = $this->getStudents();

        abort_unless(isset($students[$kelola_murid]), 404);

        return view('Admin.Kelola-Murid.edit', [
            'student' => $students[$kelola_murid],
        ]);
    }

    /**
     * Simpan murid baru.
     * NIS dibuatkan otomatis (tidak diminta lewat form).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255'],
            'status_pinjam' => ['nullable', Rule::in(['dipinjam', 'tidak_dipinjam'])],
        ]);

        $students = $this->getStudents();
        $id       = Session::get('students_next_id', count($students) + 1);
        $nis      = date('y') . str_pad((string) $id, 5, '0', STR_PAD_LEFT);

        $students[$id] = [
            'id'            => $id,
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'nis'           => $nis,
            'status_pinjam' => $validated['status_pinjam'] ?? 'tidak_dipinjam',
        ];

        Session::put('students', $students);
        Session::put('students_next_id', $id + 1);

        return redirect()
            ->route('admin.kelola-murid.index')
            ->with('success', "Murid berhasil ditambahkan. NIS: {$nis}.");
    }

    /**
     * Perbarui data murid.
     */
    public function update(Request $request, string $kelola_murid)
    {
        $students = $this->getStudents();

        abort_unless(isset($students[$kelola_murid]), 404);

        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255'],
            'status_pinjam' => ['nullable', Rule::in(['dipinjam', 'tidak_dipinjam'])],
        ]);

        $students[$kelola_murid]['name']          = $validated['name'];
        $students[$kelola_murid]['email']         = $validated['email'];
        $students[$kelola_murid]['status_pinjam'] = $validated['status_pinjam'] ?? $students[$kelola_murid]['status_pinjam'];

        Session::put('students', $students);

        return redirect()
            ->route('admin.kelola-murid.index')
            ->with('success', 'Murid berhasil diperbarui.');
    }

    /**
     * Hapus murid.
     */
    public function destroy(string $kelola_murid)
    {
        $students = $this->getStudents();

        unset($students[$kelola_murid]);

        Session::put('students', $students);

        return redirect()
            ->route('admin.kelola-murid.index')
            ->with('success', 'Murid berhasil dihapus.');
    }
}