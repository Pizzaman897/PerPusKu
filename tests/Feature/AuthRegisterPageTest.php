<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('renders the registration page', function () {
    $this->get(route('register'))
        ->assertSee('Buat Akun Anda')
        ->assertSee('name="name"', false)
        ->assertSee('name="password_confirmation"', false);
});

it('registers a user, hashes their password, and signs them in', function () {
    $this->post(route('register.store'), [
        'name' => 'Budi Santoso',
        'email' => ' BUDI.SANTOSO@example.com ',
        'password' => 'Registration-Password-2026',
        'password_confirmation' => 'Registration-Password-2026',
    ])->assertRedirect(route('user.dashboard'));

    $user = User::query()->where('email', 'budi.santoso@example.com')->firstOrFail();

    expect(Hash::check('Registration-Password-2026', $user->password))->toBeTrue()
        ->and(Auth::guard('web')->user()->is($user))->toBeTrue()
        ->and(Auth::guard('admin')->check())->toBeFalse();
});

it('rejects duplicate emails and mismatched registration passwords', function () {
    User::factory()->create([
        'email' => 'existing@example.com',
    ]);

    $this->from(route('register'))
        ->post(route('register.store'), [
            'name' => 'User Baru',
            'email' => 'existing@example.com',
            'password' => 'Registration-Password-2026',
            'password_confirmation' => 'Different-Password-2026',
        ])
        ->assertRedirect(route('register'))
        ->assertSessionHasErrors(['email', 'password']);

    $this->assertDatabaseCount('users', 1);
    expect(Auth::guard('web')->check())->toBeFalse();
});
