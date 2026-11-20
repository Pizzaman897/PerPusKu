<?php

use App\Models\Buku;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('filters books by a supported category on the user dashboard', function () {
    $novel = Buku::create([
        'judul' => 'Novel Pilihan',
        'kategori' => 'Novel',
    ]);
    Buku::create([
        'judul' => 'Kamus Bahasa',
        'kategori' => 'Kamus',
    ]);

    $this->get(route('user.dashboard', ['category' => 'Novel']))
        ->assertSee($novel->judul)
        ->assertDontSee('Kamus Bahasa')
        ->assertViewHas('selectedCategory', 'Novel')
        ->assertSee('value="Novel"', false)
        ->assertSee('value="Kamus"', false)
        ->assertSee('value="Biografi"', false)
        ->assertSee('value="Komik"', false)
        ->assertSee('value="Pelajaran"', false);
});

it('shows all books when the all-categories filter is selected', function () {
    Buku::create([
        'judul' => 'Novel Pilihan',
        'kategori' => 'Novel',
    ]);
    Buku::create([
        'judul' => 'Kamus Bahasa',
        'kategori' => 'Kamus',
    ]);

    $this->get(route('user.dashboard', ['category' => '']))
        ->assertSee('Novel Pilihan')
        ->assertSee('Kamus Bahasa')
        ->assertViewHas('selectedCategory', null);
});

it('does not show inactive books in the user catalog', function () {
    Buku::create([
        'judul' => 'Buku yang dinonaktifkan',
        'kategori' => 'Novel',
        'aktif' => false,
    ]);
    Buku::create([
        'judul' => 'Buku yang masih aktif',
        'kategori' => 'Novel',
    ]);

    $this->get(route('user.dashboard'))
        ->assertSee('Buku yang masih aktif')
        ->assertDontSee('Buku yang dinonaktifkan');
});

it('does not show a disabled book detail to users', function () {
    $book = Buku::create([
        'judul' => 'Detail buku nonaktif',
        'kategori' => 'Novel',
        'aktif' => false,
    ]);

    $this->get(route('user.book.show', $book))->assertNotFound();
});

it('returns not found for an unsupported dashboard category filter', function () {
    $this->get(route('user.dashboard', ['category' => 'Fiksi']))
        ->assertNotFound();
});
