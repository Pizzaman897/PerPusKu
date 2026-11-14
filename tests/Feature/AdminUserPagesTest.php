<?php

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('renders persisted users with delete actions', function () {
    $andi = User::factory()->create([
        'name' => 'Andi Pratama',
        'email' => 'andi.pratama@example.com',
    ]);
    User::factory()->create([
        'name' => 'Siti Rahmawati',
        'email' => 'siti.rahmawati@example.com',
    ]);

    $this->get(route('admin.users.index'))
        ->assertSee('PerPusKu')
        ->assertSee('Kelola User')
        ->assertSee('Andi Pratama')
        ->assertSee('Siti Rahmawati')
        ->assertSee('#'.$andi->id)
        ->assertSee(route('admin.users.destroy', $andi), false)
        ->assertSee('name="_method" value="DELETE"', false)
        ->assertSee('Hapus');
});

it('renders the user creation form inside the admin layout', function () {
    $this->get(route('admin.users.create'))
        ->assertSee('PerPusKu')
        ->assertSee('Tambah user')
        ->assertSee('Kata sandi awal')
        ->assertSee('Konfirmasi kata sandi')
        ->assertSee('Simpan data user');
});

it('prefills the edit form with the selected sample user', function () {
    $user = User::factory()->create([
        'name' => 'Siti Rahmawati',
        'email' => 'siti.rahmawati@example.com',
    ]);

    $this->get(route('admin.users.edit', $user))
        ->assertSee('Siti Rahmawati')
        ->assertSee('siti.rahmawati@example.com')
        ->assertSee('Kata sandi baru');
});

it('shows user details and returns not found for an unknown user', function () {
    $user = User::factory()->create([
        'name' => 'Andi Pratama',
        'email' => 'andi.pratama@example.com',
    ]);

    $this->get(route('admin.users.show', $user))
        ->assertSee('Andi Pratama')
        ->assertSee('andi.pratama@example.com')
        ->assertSee('Dibuat pada')
        ->assertSee('Diperbarui pada');

    $this->get(route('admin.users.show', 999999))->assertNotFound();
});

it('omits the removed identifier from user pages', function () {
    $user = User::factory()->create();

    $this->get(route('admin.users.index'))
        ->assertDontSee('NIS');

    $this->get(route('admin.users.create'))
        ->assertDontSee('NIS');

    $this->get(route('admin.users.edit', $user))
        ->assertDontSee('NIS');

    $this->get(route('admin.users.show', $user))
        ->assertDontSee('NIS');
});

it('deletes a user without borrowing history', function () {
    $user = User::factory()->create();

    $this->delete(route('admin.users.destroy', $user))
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success', 'User berhasil dihapus.');

    $this->assertModelMissing($user);

    $this->get(route('admin.users.index'))
        ->assertSee('User berhasil dihapus.');
});

it('keeps a user who has borrowing history', function () {
    $user = User::factory()->create();
    $book = Buku::create([
        'judul' => 'Matematika',
        'kategori' => 'pelajaran',
        'deskripsi' => 'Buku pelajaran.',
        'url_sampul' => null,
    ]);
    Peminjaman::create([
        'user_id' => $user->id,
        'buku_id' => $book->id,
        'dipinjam_pada' => '2026-11-13 09:00:00',
        'batas_pengembalian' => '2026-11-20 09:00:00',
        'dikembalikan_pada' => null,
    ]);

    $this->delete(route('admin.users.destroy', $user))
        ->assertRedirect()
        ->assertSessionHas('error', 'User tidak dapat dihapus karena masih memiliki riwayat peminjaman.');

    $this->assertModelExists($user);

    $this->get(route('admin.users.index'))
        ->assertSee('User tidak dapat dihapus karena masih memiliki riwayat peminjaman.');
});

it('creates a user and stores the submitted password securely', function () {
    $this->post(route('admin.users.store'), [
        'name' => 'Budi Santoso',
        'email' => 'budi.santoso@example.com',
        'password' => 'User-Password-2026',
        'password_confirmation' => 'User-Password-2026',
    ])->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success', 'User berhasil ditambahkan.');

    $user = User::where('email', 'budi.santoso@example.com')->firstOrFail();

    expect(Hash::check('User-Password-2026', $user->password))->toBeTrue();
});

it('updates a user password when a new one is provided', function () {
    $user = User::factory()->create();

    $this->put(route('admin.users.update', $user), [
        'name' => $user->name,
        'email' => $user->email,
        'password' => 'Updated-User-Password-2026',
        'password_confirmation' => 'Updated-User-Password-2026',
    ])->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success', 'User berhasil diperbarui.');

    expect(Hash::check('Updated-User-Password-2026', $user->refresh()->password))->toBeTrue();
});

it('authenticates a user with the saved email and password', function () {
    $user = User::factory()->create([
        'email' => 'user.login@example.com',
        'password' => 'User-Login-Password-2026',
    ]);

    $this->post(route('login.authenticate'), [
        'email' => 'user.login@example.com',
        'password' => 'User-Login-Password-2026',
    ])->assertRedirect(route('user.dashboard'));

    expect(Auth::guard('web')->user()->is($user))->toBeTrue();
});
