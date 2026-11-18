<?php

use App\Models\Admin;
use App\Models\Buku;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('seeds one admin, one user, and the 3726 MDPL book idempotently', function () {
    config([
        'seeders.admin_password' => 'admin-test-password',
        'seeders.user_password' => 'user-test-password',
    ]);

    $this->seed(DatabaseSeeder::class);
    $this->seed(DatabaseSeeder::class);

    $admin = Admin::query()->where('email', 'admin@gmail.com')->sole();
    $user = User::query()->where('email', 'user@gmail.com')->sole();
    $book = Buku::query()->where('judul', '3726 MDPL')->sole();

    expect($admin->name)->toBe('Admin1')
        ->and(Hash::check('admin-test-password', $admin->password))->toBeTrue()
        ->and($user->name)->toBe('User1')
        ->and(Hash::check('user-test-password', $user->password))->toBeTrue()
        ->and($book->kategori)->toBe('Novel')
        ->and($book->deskripsi)->toContain('Gunung Rinjani')
        ->and($book->url_sampul)->toBe('https://image.gramedia.net/rs:fit:0:0/f:webp/plain/https://cdn.gramedia.com/uploads/products/9397p4603v.jpg');

    $this->assertDatabaseCount('admins', 1);
    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseCount('buku', 1);
});
