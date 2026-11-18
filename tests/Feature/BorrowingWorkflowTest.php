<?php

use App\Models\Admin;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

it('creates a pending borrowing request for the signed-in user', function () {
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Buku baru',
        'kategori' => 'Fiksi',
    ]);

    $this->actingAs($user, 'web')
        ->post(route('user.book.pinjam', $book))
        ->assertRedirect(route('user.status'))
        ->assertSessionHas('success', 'Permintaan peminjaman dikirim dan menunggu persetujuan admin.');

    $borrowing = Peminjaman::query()->sole();

    expect($borrowing->user_id)->toBe($user->id)
        ->and($borrowing->buku_id)->toBe($book->id)
        ->and($borrowing->status)->toBe('pending')
        ->and($borrowing->batas_pengembalian)->toBeNull();

    $this->actingAs($user, 'web')
        ->get(route('user.status'))
        ->assertSee('Pending - menunggu persetujuan')
        ->assertSee('Belum diatur admin');
});

it('shows a borrowing as overdue after its Jakarta deadline', function () {
    $this->travelTo(Carbon::parse('2026-11-18 10:00:00', 'Asia/Jakarta'));
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Buku terlambat',
        'kategori' => 'Fiksi',
    ]);

    Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => '2026-11-18 08:00:00',
        'batas_pengembalian' => '2026-11-18 09:00:00',
        'status' => 'dipinjam',
    ]);

    $this->actingAs($user, 'web')
        ->get(route('user.status'))
        ->assertSee('Lewat batas waktu');
});

it('requires an admin to set a deadline before approving a borrowing', function () {
    $this->travelTo('2026-11-18 10:00:00');
    $admin = new Admin(['name' => 'Admin']);
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Buku baru',
        'kategori' => 'Fiksi',
    ]);
    $borrowing = Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => now(),
        'status' => 'pending',
    ]);

    $this->actingAs($admin, 'admin')
        ->put(route('admin.status.update', $borrowing), ['status' => 'dipinjam'])
        ->assertRedirect()
        ->assertSessionHas('error', 'Atur batas pengembalian sebelum menyetujui peminjaman.');

    $this->put(route('admin.status.update', $borrowing), [
        'batas_pengembalian' => '2026-11-25T10:00',
    ])
        ->assertRedirect()
        ->assertSessionHas('success', 'Data peminjaman berhasil diperbarui.');

    $this->put(route('admin.status.update', $borrowing), [
        'batas_pengembalian' => '2026-11-27T10:00',
    ])
        ->assertRedirect()
        ->assertSessionHas('success', 'Data peminjaman berhasil diperbarui.');

    $this->put(route('admin.status.update', $borrowing), ['status' => 'dipinjam'])
        ->assertRedirect()
        ->assertSessionHas('success', 'Data peminjaman berhasil diperbarui.');

    $this->assertDatabaseHas('peminjaman', [
        'id' => $borrowing->id,
        'status' => 'dipinjam',
        'batas_pengembalian' => '2026-11-27 10:00:00',
    ]);

    $this->put(route('admin.status.update', $borrowing), [
        'status' => 'pending',
        'batas_pengembalian' => '2026-11-30T10:00',
    ])
        ->assertRedirect()
        ->assertSessionHas('error', 'Status peminjaman sudah ditetapkan dan tidak dapat diubah lagi.');

    $this->assertDatabaseHas('peminjaman', [
        'id' => $borrowing->id,
        'status' => 'dipinjam',
        'batas_pengembalian' => '2026-11-27 10:00:00',
    ]);
});

it('does not allow a regular user to change admin borrowing status', function () {
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Buku baru',
        'kategori' => 'Fiksi',
    ]);
    $borrowing = Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => now(),
        'status' => 'pending',
    ]);

    $this->actingAs($user, 'web')
        ->put(route('admin.status.update', $borrowing), ['status' => 'dipinjam'])
        ->assertRedirect(route('login'));

    $this->assertDatabaseHas('peminjaman', [
        'id' => $borrowing->id,
        'status' => 'pending',
    ]);
});

it('marks a book returned when the user returns it by the deadline', function () {
    $this->travelTo('2026-11-19 10:00:00');
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Buku tepat waktu',
        'kategori' => 'Fiksi',
    ]);
    $borrowing = Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => '2026-11-18 10:00:00',
        'batas_pengembalian' => '2026-11-20 10:00:00',
        'status' => 'dipinjam',
    ]);

    $this->actingAs($user, 'web')
        ->post(route('user.book.kembalikan', $borrowing))
        ->assertRedirect(route('user.status'))
        ->assertSessionHas('success', 'Buku berhasil dikembalikan.');

    $this->assertDatabaseHas('peminjaman', [
        'id' => $borrowing->id,
        'status' => 'dikembalikan',
        'dikembalikan_pada' => '2026-11-19 10:00:00',
    ]);
});

it('marks a book returned late when the user returns it after the deadline', function () {
    $this->travelTo('2026-11-21 10:00:00');
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Buku terlambat',
        'kategori' => 'Fiksi',
    ]);
    $borrowing = Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => '2026-11-18 10:00:00',
        'batas_pengembalian' => '2026-11-20 10:00:00',
        'status' => 'dipinjam',
    ]);

    $this->actingAs($user, 'web')
        ->post(route('user.book.kembalikan', $borrowing))
        ->assertRedirect(route('user.status'));

    $this->assertDatabaseHas('peminjaman', [
        'id' => $borrowing->id,
        'status' => 'terlambat',
        'dikembalikan_pada' => '2026-11-21 10:00:00',
    ]);
});

it('does not allow a user to return another user borrowing', function () {
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Buku milik user lain',
        'kategori' => 'Fiksi',
    ]);
    $borrowing = Peminjaman::create([
        'user_id' => $owner->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => now(),
        'batas_pengembalian' => now()->addDays(7),
        'status' => 'dipinjam',
    ]);

    $this->actingAs($otherUser, 'web')
        ->post(route('user.book.kembalikan', $borrowing))
        ->assertNotFound();

    $this->assertModelExists($borrowing);
});
