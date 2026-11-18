<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        abort_unless($search === null || is_string($search), 422);
        $search = trim($search ?? '');
        abort_if(mb_strlen($search) > 255, 422);

        $category = $request->query('category');
        $category = $category === '' ? null : $category;
        abort_unless(
            $category === null || (is_string($category) && in_array($category, Buku::CATEGORIES, true)),
            422,
        );

        $status = $request->query('status');
        $status = $status === '' ? null : $status;
        abort_unless(
            $status === null || (is_string($status) && in_array($status, ['available', 'borrowed'], true)),
            422,
        );

        $books = Buku::query()
            ->withExists([
                'peminjaman as sedang_dipinjam' => fn ($query) => $query->whereNull('dikembalikan_pada'),
            ])
            ->when($search !== '', fn ($query) => $query->where('judul', 'like', "%{$search}%"))
            ->when($category !== null, fn ($query) => $query->where('kategori', $category))
            ->when(
                $status === 'available',
                fn ($query) => $query->whereDoesntHave(
                    'peminjaman',
                    fn ($borrowingQuery) => $borrowingQuery->whereNull('dikembalikan_pada'),
                ),
            )
            ->when(
                $status === 'borrowed',
                fn ($query) => $query->whereHas(
                    'peminjaman',
                    fn ($borrowingQuery) => $borrowingQuery->whereNull('dikembalikan_pada'),
                ),
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.books.index', [
            'title' => 'PerPusKu - Kelola Buku',
            'books' => $books,
            'categories' => Buku::CATEGORIES,
            'search' => $search,
            'selectedCategory' => $category,
            'selectedStatus' => $status,
        ]);
    }

    public function create(): View
    {
        return view('admin.books.create', [
            'title' => 'PerPusKu - Tambah Buku',
            'categories' => Buku::CATEGORIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', Rule::in(Buku::CATEGORIES)],
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
            'categories' => Buku::CATEGORIES,
        ]);
    }

    public function update(Request $request, Buku $buku): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', Rule::in(Buku::CATEGORIES)],
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
