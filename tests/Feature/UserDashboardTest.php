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

it('returns not found for an unsupported dashboard category filter', function () {
    $this->get(route('user.dashboard', ['category' => 'Fiksi']))
        ->assertNotFound();
});
