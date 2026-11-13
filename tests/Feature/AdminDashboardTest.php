<?php

use App\Models\Admin;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows live database totals for books, users, and admins', function () {
    User::factory()->count(3)->create();

    foreach (range(1, 4) as $number) {
        Admin::create([
            'name' => "Admin {$number}",
            'email' => "admin{$number}@example.com",
            'password' => 'password',
        ]);
    }

    foreach (range(1, 2) as $number) {
        Buku::create([
            'judul' => "Buku {$number}",
            'kategori' => 'Umum',
        ]);
    }

    $this->get(route('admin.dashboard'))
        ->assertViewHas('totalBuku', 2)
        ->assertViewHas('totalUsers', 3)
        ->assertViewHas('totalAdmin', 4)
        ->assertSee('Total admin')
        ->assertSee(route('admin.kelola-admin.index'))
        ->assertDontSee('Buku sedang dipinjam');
});
