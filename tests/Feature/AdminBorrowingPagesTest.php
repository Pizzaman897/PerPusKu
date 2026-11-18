<?php

use App\Models\Admin;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows borrowing records with editable status and deadline controls', function () {
    $this->travelTo('2026-09-10 12:00:00');
    $admin = new Admin(['name' => 'Admin']);
    $user = User::factory()->create(['name' => 'Budi']);
    $book = Buku::create([
        'judul' => 'Gajah Minum Air',
        'kategori' => 'Fiksi',
    ]);

    Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => '2026-09-01 08:00:00',
        'status' => 'pending',
    ]);
    Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => '2026-09-01 08:00:00',
        'batas_pengembalian' => '2026-09-08 09:00:00',
        'dikembalikan_pada' => '2026-09-08 08:00:00',
        'status' => 'dikembalikan',
    ]);
    $overdue = Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => '2026-09-01 08:15:00',
        'batas_pengembalian' => '2026-09-08 09:00:00',
        'status' => 'dipinjam',
    ]);

    $this->actingAs($admin, 'admin')
        ->get(route('admin.status.index'))
        ->assertSee('#'.$overdue->id)
        ->assertSee('Budi')
        ->assertSee('Gajah Minum Air')
        ->assertSee('Lewat batas waktu')
        ->assertSee('Dikembalikan')
        ->assertSee('name="status"', false)
        ->assertSee('value="dikembalikan"', false)
        ->assertSee('value="terlambat"', false)
        ->assertSee('name="batas_pengembalian"', false);
});

it('allows an approved borrowing to be marked returned or late without editing its deadline', function () {
    $admin = new Admin(['name' => 'Admin']);
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Gajah Minum Air',
        'kategori' => 'Fiksi',
    ]);

    Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => now(),
        'batas_pengembalian' => now()->addDays(7),
        'status' => 'dipinjam',
    ]);

    $this->actingAs($admin, 'admin')
        ->get(route('admin.status.index'))
        ->assertSee('name="status"', false)
        ->assertSee('value="dikembalikan"', false)
        ->assertSee('value="terlambat"', false)
        ->assertDontSee('name="batas_pengembalian"', false);
});

it('redirects guests away from the admin borrowing status page', function () {
    $this->get(route('admin.status.index'))
        ->assertRedirect(route('login'));
});
