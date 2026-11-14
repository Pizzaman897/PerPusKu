<?php

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('shows password fields when creating and editing an admin', function () {
    $admin = Admin::create([
        'name' => 'Admin Form',
        'email' => 'admin.form@example.com',
        'password' => 'Password-Form-2026',
    ]);

    $this->get(route('admin.kelola-admin.create'))
        ->assertSee('name="password"', false)
        ->assertSee('name="password_confirmation"', false);

    $this->get(route('admin.kelola-admin.edit', $admin))
        ->assertSee('Kata sandi baru')
        ->assertSee('name="password_confirmation"', false);
});

it('creates an admin with a usable password', function () {
    $this->post(route('admin.kelola-admin.store'), [
        'name' => 'Admin Baru',
        'email' => 'admin.baru@example.com',
        'password' => 'Perpusku-Admin-2026',
        'password_confirmation' => 'Perpusku-Admin-2026',
    ])->assertRedirect(route('admin.kelola-admin.index'));

    $admin = Admin::where('email', 'admin.baru@example.com')->firstOrFail();

    expect(Hash::check('Perpusku-Admin-2026', $admin->password))->toBeTrue();
});

it('updates an admin password when a new one is provided', function () {
    $admin = Admin::create([
        'name' => 'Admin Lama',
        'email' => 'admin.lama@example.com',
        'password' => 'Password-Lama-2026',
    ]);

    $this->put(route('admin.kelola-admin.update', $admin), [
        'name' => $admin->name,
        'email' => $admin->email,
        'password' => 'Password-Baru-2026',
        'password_confirmation' => 'Password-Baru-2026',
    ])->assertRedirect(route('admin.kelola-admin.index'));

    expect(Hash::check('Password-Baru-2026', $admin->refresh()->password))->toBeTrue();
});

it('keeps an admin password when the edit password is left blank', function () {
    $admin = Admin::create([
        'name' => 'Admin Tetap',
        'email' => 'admin.tetap@example.com',
        'password' => 'Password-Lama-2026',
    ]);

    $this->put(route('admin.kelola-admin.update', $admin), [
        'name' => $admin->name,
        'email' => $admin->email,
        'password' => '',
        'password_confirmation' => '',
    ])->assertRedirect(route('admin.kelola-admin.index'));

    expect(Hash::check('Password-Lama-2026', $admin->refresh()->password))->toBeTrue();
});

it('authenticates an admin with the saved email and password', function () {
    $admin = Admin::create([
        'name' => 'Admin Login',
        'email' => 'admin.login@example.com',
        'password' => 'Password-Login-2026',
    ]);

    $this->post(route('login.authenticate'), [
        'email' => 'admin.login@example.com',
        'password' => 'Password-Login-2026',
    ])->assertRedirect(route('admin.dashboard'));

    expect(Auth::guard('admin')->user()->is($admin))->toBeTrue();
});

it('rejects an admin login with an incorrect password', function () {
    Admin::create([
        'name' => 'Admin Gagal',
        'email' => 'admin.gagal@example.com',
        'password' => 'Password-Benar-2026',
    ]);

    $this->from(route('login'))
        ->post(route('login.authenticate'), [
            'email' => 'admin.gagal@example.com',
            'password' => 'Password-Salah-2026',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');

    expect(Auth::guard('admin')->check())->toBeFalse();
});
