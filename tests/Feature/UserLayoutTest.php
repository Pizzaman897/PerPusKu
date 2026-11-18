<?php

use App\Models\Buku;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('reuses the branded user layout across library pages', function () {
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Buku untuk layout',
        'kategori' => 'Umum',
    ]);

    $this->actingAs($user, 'web');

    foreach ([
        route('user.dashboard'),
        route('user.status'),
        route('user.history'),
        route('user.book.show', $book),
    ] as $url) {
        $this->get($url)
            ->assertSee('PerPusKu')
            ->assertSee('Keluar');
    }
});

it('renders the available book cards on the user dashboard', function () {
    User::factory()->create();
    Buku::create([
        'judul' => 'Matematika SMA/SMK Kelas X',
        'kategori' => 'Pelajaran',
    ]);

    $this->get(route('user.dashboard'))
        ->assertSee('Matematika SMA/SMK Kelas X')
        ->assertSee('Tersedia');
});
