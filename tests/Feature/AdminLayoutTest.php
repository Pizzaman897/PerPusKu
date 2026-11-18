<?php

use App\Models\Admin;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('reuses the branded admin layout across dashboard and book pages', function () {
    $admin = new Admin(['name' => 'Admin Test']);
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
        $this->actingAs($admin, 'admin')
            ->get($url)
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

it('redirects guests from admin pages to login', function () {
    foreach ([
        route('admin.dashboard'),
        route('admin.buku.index'),
        route('admin.users.index'),
        route('admin.kelola-admin.index'),
    ] as $url) {
        $this->get($url)->assertRedirect(route('login'));
    }
});

it('redirects regular users away from admin pages', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'web')
        ->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});
