<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $selectedCategory = $request->query('category');
        $selectedCategory = $selectedCategory === '' ? null : $selectedCategory;

        abort_unless(
            $selectedCategory === null
                || (is_string($selectedCategory) && in_array($selectedCategory, Buku::CATEGORIES, true)),
            404,
        );

        $books = Buku::query()
            ->when($selectedCategory !== null, fn ($query) => $query->where('kategori', $selectedCategory))
            ->withExists([
                'peminjaman as sedang_dipinjam' => fn ($query) => $query->whereNull('dikembalikan_pada'),
            ])
            ->latest()
            ->get();

        return view('user.dashboard', [
            'title' => 'PerPusKu - Beranda',
            'books' => $books,
            'categories' => Buku::CATEGORIES,
            'selectedCategory' => $selectedCategory,
        ]);
    }
}
