<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(): View
    {
        return view('admin.books.index', [
            'title' => 'PerPusKu - Kelola Buku',
            'books' => Buku::query()
                ->withExists([
                    'peminjaman as sedang_dipinjam' => fn ($query) => $query->whereNull('dikembalikan_pada'),
                ])
                ->latest()
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.books.create', [
            'title' => 'PerPusKu - Tambah Buku',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url', 'max:255'],
        ]);

        Buku::create([
            'judul' => $validated['title'],
            'kategori' => $validated['category'],
            'deskripsi' => $validated['description'] ?? null,
            'url_sampul' => $validated['image_url'] ?? null,
        ]);

        return redirect()
            ->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku): View
    {
        return view('admin.books.show', [
            'title' => 'PerPusKu - Detail Buku',
            'book' => $buku,
            'sedangDipinjam' => $buku->peminjaman()->whereNull('dikembalikan_pada')->exists(),
        ]);
    }

    public function edit(Buku $buku): View
    {
        return view('admin.books.edit', [
            'title' => 'PerPusKu - Edit Buku',
            'buku' => $buku,
        ]);
    }

    public function update(Request $request, Buku $buku): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url', 'max:255'],
        ]);

        $buku->update([
            'judul' => $validated['title'],
            'kategori' => $validated['category'],
            'deskripsi' => $validated['description'] ?? null,
            'url_sampul' => $validated['image_url'] ?? null,
        ]);

        return redirect()
            ->route('admin.buku.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku): RedirectResponse
    {
        if ($buku->peminjaman()->exists()) {
            return back()
                ->with('error', 'Buku tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        $buku->delete();

        return redirect()
            ->route('admin.buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}
