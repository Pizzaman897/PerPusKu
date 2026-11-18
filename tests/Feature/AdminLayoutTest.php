<?php

use App\Models\Admin;
use App\Models\Buku;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('reuses the branded admin layout across dashboard and book pages', function () {
    $book = Buku::create([
        'judul' => 'Buku untuk layout',
        'kategori' => 'Umum',
    ]);

    foreach ([
        route('admin.dashboard'),
        route('admin.buku.index'),
        route('admin.buku.create'),
        route('admin.buku.edit', $book),
        route('admin.kelola-admin.create'),
    ] as $url) {
        $this->get($url)
            ->assertSee('PerPusKu')
            ->assertSee('Kelola User');
    }
});

it('shows the signed-in admin name across admin pages', function () {
    $admin = new Admin(['name' => 'Nadia Admin']);

    foreach ([
        route('admin.dashboard'),
        route('admin.buku.index'),
        route('admin.status.index'),
        route('admin.kelola-admin.index'),
        route('admin.users.index'),
    ] as $url) {
        $this->actingAs($admin, 'admin')
            ->get($url)
            ->assertSee('Nadia Admin');
    }
});
