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

it('rejects a borrowing request for a disabled book', function () {
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Buku nonaktif',
        'kategori' => 'Novel',
        'aktif' => false,
    ]);

    $this->actingAs($user, 'web')
        ->post(route('user.book.pinjam', $book))
        ->assertNotFound();

    $this->assertDatabaseCount('peminjaman', 0);
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
        ->assertSessionHas('error', 'Peminjaman yang sedang berlangsung tidak dapat dikembalikan ke status Pending.');

    $this->assertDatabaseHas('peminjaman', [
        'id' => $borrowing->id,
        'status' => 'dipinjam',
        'batas_pengembalian' => '2026-11-27 10:00:00',
    ]);
});

it('rejects invalid borrowing status and deadline updates', function () {
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
        ->put(route('admin.status.update', $borrowing), [
            'status' => 'ditolak',
            'batas_pengembalian' => '2026-11-17T10:00',
        ])
        ->assertSessionHasErrors(['status', 'batas_pengembalian']);

    $this->assertDatabaseHas('peminjaman', [
        'id' => $borrowing->id,
        'status' => 'pending',
        'batas_pengembalian' => null,
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

it('does not allow the admin to change a deadline after approving a borrowing', function () {
    $this->travelTo('2026-11-19 10:00:00');
    $admin = new Admin(['name' => 'Admin']);
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Batas sudah ditetapkan',
        'kategori' => 'Fiksi',
    ]);
    $borrowing = Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => now()->subDay(),
        'batas_pengembalian' => '2026-11-25 10:00:00',
        'status' => 'dipinjam',
    ]);

    $this->actingAs($admin, 'admin')
        ->put(route('admin.status.update', $borrowing), [
            'batas_pengembalian' => '2026-11-27T10:00',
        ])
        ->assertSessionHas('error', 'Batas pengembalian hanya dapat diubah saat status masih Pending.');

    $this->assertDatabaseHas('peminjaman', [
        'id' => $borrowing->id,
        'batas_pengembalian' => '2026-11-25 10:00:00',
    ]);
});

it('shows only active borrowings on the status page and completed ones in history', function () {
    $user = User::factory()->create();
    $activeBook = Buku::create([
        'judul' => 'Buku masih dipinjam',
        'kategori' => 'Fiksi',
    ]);
    $returnedBook = Buku::create([
        'judul' => 'Buku sudah kembali',
        'kategori' => 'Fiksi',
    ]);

    Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $activeBook->id,
        'dipinjam_pada' => now(),
        'batas_pengembalian' => now()->addDays(7),
        'status' => 'dipinjam',
    ]);
    Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $returnedBook->id,
        'dipinjam_pada' => now()->subDays(7),
        'batas_pengembalian' => now()->subDay(),
        'dikembalikan_pada' => now(),
        'status' => 'terlambat',
    ]);

    $this->actingAs($user, 'web')
        ->get(route('user.status'))
        ->assertSee($activeBook->judul)
        ->assertDontSee($returnedBook->judul)
        ->assertDontSee('Kembalikan buku');

    $this->get(route('user.history'))
        ->assertSee($returnedBook->judul)
        ->assertSee('Terlambat')
        ->assertDontSee($activeBook->judul);
});

it('lets the admin set the final status allowed by the deadline and moves the book to history', function (string $status, string $now, string $deadline, string $label) {
    $this->travelTo($now);
    $admin = new Admin(['name' => 'Admin']);
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Buku selesai dikelola admin',
        'kategori' => 'Fiksi',
    ]);
    $borrowing = Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => '2026-11-18 10:00:00',
        'batas_pengembalian' => $deadline,
        'status' => 'dipinjam',
    ]);

    $this->actingAs($admin, 'admin')
        ->put(route('admin.status.update', $borrowing), ['status' => $status])
        ->assertRedirect()
        ->assertSessionHas('success', 'Data peminjaman berhasil diperbarui.');

    $this->assertDatabaseHas('peminjaman', [
        'id' => $borrowing->id,
        'status' => $status,
        'dikembalikan_pada' => $now,
    ]);

    $this->actingAs($user, 'web')
        ->get(route('user.status'))
        ->assertDontSee($book->judul);

    $this->get(route('user.history'))
        ->assertSee($book->judul)
        ->assertSee($label);

    $this->actingAs($admin, 'admin')
        ->put(route('admin.status.update', $borrowing), ['status' => 'dipinjam'])
        ->assertSessionHas('error', 'Status peminjaman sudah ditetapkan dan tidak dapat diubah lagi.');

    $this->assertDatabaseHas('peminjaman', [
        'id' => $borrowing->id,
        'status' => $status,
    ]);
})->with([
    'returned before deadline' => ['dikembalikan', '2026-11-19 10:00:00', '2026-11-20 10:00:00', 'Dikembalikan'],
    'late after deadline' => ['terlambat', '2026-11-21 10:00:00', '2026-11-20 10:00:00', 'Terlambat'],
]);

it('rejects a final status that conflicts with the deadline', function (string $status, string $now, string $deadline, string $message) {
    $this->travelTo($now);
    $admin = new Admin(['name' => 'Admin']);
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Buku belum selesai',
        'kategori' => 'Fiksi',
    ]);
    $borrowing = Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => '2026-11-18 10:00:00',
        'batas_pengembalian' => $deadline,
        'status' => 'dipinjam',
    ]);

    $this->actingAs($admin, 'admin')
        ->put(route('admin.status.update', $borrowing), ['status' => $status])
        ->assertRedirect()
        ->assertSessionHas('error', $message);

    $this->assertDatabaseHas('peminjaman', [
        'id' => $borrowing->id,
        'status' => 'dipinjam',
        'dikembalikan_pada' => null,
    ]);
})->with([
    'not late before deadline' => [
        'terlambat',
        '2026-11-19 10:00:00',
        '2026-11-20 10:00:00',
        'Batas pengembalian belum lewat; status hanya dapat diubah menjadi Dikembalikan.',
    ],
    'not on-time after deadline' => [
        'dikembalikan',
        '2026-11-21 10:00:00',
        '2026-11-20 10:00:00',
        'Batas pengembalian sudah lewat; status hanya dapat diubah menjadi Terlambat.',
    ],
]);

it('does not allow a pending borrowing to be completed without approval', function () {
    $this->travelTo('2026-11-18 10:00:00');
    $admin = new Admin(['name' => 'Admin']);
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Buku masih Pending',
        'kategori' => 'Fiksi',
    ]);
    $borrowing = Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => now(),
        'batas_pengembalian' => now()->addDay(),
        'status' => 'pending',
    ]);

    $this->actingAs($admin, 'admin')
        ->put(route('admin.status.update', $borrowing), ['status' => 'dikembalikan'])
        ->assertRedirect()
        ->assertSessionHas('error', 'Peminjaman harus disetujui sebelum dapat diselesaikan.');

    $this->assertDatabaseHas('peminjaman', [
        'id' => $borrowing->id,
        'status' => 'pending',
        'dikembalikan_pada' => null,
    ]);
});

it('requires a future deadline when approving a pending borrowing', function () {
    $this->travelTo('2026-11-21 10:00:00');
    $admin = new Admin(['name' => 'Admin']);
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Batas peminjaman sudah lewat',
        'kategori' => 'Fiksi',
    ]);
    $borrowing = Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => '2026-11-18 10:00:00',
        'batas_pengembalian' => '2026-11-20 10:00:00',
        'status' => 'pending',
    ]);

    $this->actingAs($admin, 'admin')
        ->put(route('admin.status.update', $borrowing), ['status' => 'dipinjam'])
        ->assertRedirect()
        ->assertSessionHas('error', 'Batas pengembalian sudah lewat; atur ulang sebelum menyetujui peminjaman.');

    $this->assertDatabaseHas('peminjaman', [
        'id' => $borrowing->id,
        'status' => 'pending',
    ]);
});

it('does not expose a user return action or endpoint', function () {
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Buku milik user',
        'kategori' => 'Fiksi',
    ]);
    $borrowing = Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => now(),
        'batas_pengembalian' => now()->addDays(7),
        'status' => 'dipinjam',
    ]);

    $this->actingAs($user, 'web')
        ->post('/user/peminjaman/'.$borrowing->id.'/kembalikan')
        ->assertNotFound();
});
