<?php

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders book details with the shared admin layout', function () {
    $book = Buku::create([
        'judul' => 'Gajah Minum Air',
        'kategori' => 'Fiksi',
        'deskripsi' => 'Kisah ringan tentang petualangan dan persahabatan.',
    ]);

    $this->get(route('admin.buku.show', $book))
        ->assertSee('PerPusKu')
        ->assertSee('Gajah Minum Air')
        ->assertSee('Kisah ringan tentang petualangan dan persahabatan.')
        ->assertSee('Tersedia')
        ->assertSee('ID Buku')
        ->assertSee('Dibuat pada')
        ->assertSee('Diperbarui pada');
});

it('shows book identifiers in the collection list and keeps availability derived', function () {
    $book = Buku::create([
        'judul' => 'Buku di database',
        'kategori' => 'Umum',
        'deskripsi' => 'Deskripsi buku.',
    ]);

    $this->get(route('admin.buku.index'))
        ->assertSee('#'.$book->id)
        ->assertSee('Buku di database')
        ->assertSee('Tersedia');

    $this->get(route('admin.buku.create'))
        ->assertSee('Status awal buku otomatis')
        ->assertDontSee('name="status"', false);
});

it('creates a book with the submitted details', function () {
    $this->post(route('admin.buku.store'), [
        'title' => 'Petualangan Baru',
        'category' => 'Fiksi',
        'description' => 'Cerita untuk pembaca muda.',
        'image_url' => 'https://example.com/sampul.jpg',
    ])
        ->assertRedirect(route('admin.buku.index'))
        ->assertSessionHas('success', 'Buku berhasil ditambahkan.');

    $this->assertDatabaseHas('buku', [
        'judul' => 'Petualangan Baru',
        'kategori' => 'Fiksi',
        'deskripsi' => 'Cerita untuk pembaca muda.',
        'url_sampul' => 'https://example.com/sampul.jpg',
    ]);
});

it('returns validation errors when required book details are missing', function () {
    $this->from(route('admin.buku.create'))
        ->post(route('admin.buku.store'), [
            'title' => '',
            'category' => '',
        ])
        ->assertRedirect(route('admin.buku.create'))
        ->assertSessionHasErrors(['title', 'category']);

    $this->assertDatabaseCount('buku', 0);
});

it('prefills the edit form and updates the selected book', function () {
    $book = Buku::create([
        'judul' => 'Judul Lama',
        'kategori' => 'Pelajaran',
        'deskripsi' => 'Deskripsi lama.',
        'url_sampul' => null,
    ]);

    $this->get(route('admin.buku.edit', $book))
        ->assertSee('Judul Lama')
        ->assertSee('Pelajaran')
        ->assertSee('Deskripsi lama.');

    $this->put(route('admin.buku.update', $book), [
        'title' => 'Judul Baru',
        'category' => 'Non-fiksi',
        'description' => 'Deskripsi baru.',
        'image_url' => 'https://example.com/buku-baru.jpg',
    ])
        ->assertRedirect(route('admin.buku.index'))
        ->assertSessionHas('success', 'Buku berhasil diperbarui.');

    $this->assertDatabaseHas('buku', [
        'id' => $book->id,
        'judul' => 'Judul Baru',
        'kategori' => 'Non-fiksi',
        'deskripsi' => 'Deskripsi baru.',
        'url_sampul' => 'https://example.com/buku-baru.jpg',
    ]);
});

it('returns not found when a requested book does not exist', function () {
    $this->get(route('admin.buku.show', 999999))->assertNotFound();
});

it('deletes a book without borrowing history', function () {
    $book = Buku::create([
        'judul' => 'Buku yang dihapus',
        'kategori' => 'Umum',
    ]);

    $this->delete(route('admin.buku.destroy', $book))
        ->assertRedirect(route('admin.buku.index'))
        ->assertSessionHas('success', 'Buku berhasil dihapus.');

    $this->assertModelMissing($book);

    $this->get(route('admin.buku.index'))
        ->assertDontSee('Buku yang dihapus')
        ->assertSee('Buku berhasil dihapus.');
});

it('keeps a book that has borrowing history', function () {
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Buku dengan riwayat',
        'kategori' => 'Umum',
    ]);
    Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => '2026-11-13 09:00:00',
        'batas_pengembalian' => '2026-11-20 09:00:00',
        'dikembalikan_pada' => null,
    ]);

    $this->delete(route('admin.buku.destroy', $book))
        ->assertRedirect()
        ->assertSessionHas('error', 'Buku tidak dapat dihapus karena memiliki riwayat peminjaman.');

    $this->assertModelExists($book);
});
