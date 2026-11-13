<?php

use App\Models\Admin;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

it('maps each model to its existing database table', function () {
    expect((new User)->getTable())->toBe('users')
        ->and((new Admin)->getTable())->toBe('admins')
        ->and((new Buku)->getTable())->toBe('buku')
        ->and((new Peminjaman)->getTable())->toBe('peminjaman');
});

it('relates users and books to their borrowings through the correct foreign keys', function () {
    $userBorrowings = (new User)->peminjaman();
    $bookBorrowings = (new Buku)->peminjaman();

    expect($userBorrowings)->toBeInstanceOf(HasMany::class)
        ->and($userBorrowings->getForeignKeyName())->toBe('user_id')
        ->and($bookBorrowings)->toBeInstanceOf(HasMany::class)
        ->and($bookBorrowings->getForeignKeyName())->toBe('buku_id');
});

it('relates each borrowing to its user and book', function () {
    $borrowing = new Peminjaman;
    $user = $borrowing->user();
    $book = $borrowing->buku();

    expect($user)->toBeInstanceOf(BelongsTo::class)
        ->and($user->getForeignKeyName())->toBe('user_id')
        ->and($user->getRelated())->toBeInstanceOf(User::class)
        ->and($book)->toBeInstanceOf(BelongsTo::class)
        ->and($book->getForeignKeyName())->toBe('buku_id')
        ->and($book->getRelated())->toBeInstanceOf(Buku::class);
});

it('casts borrowing dates to Carbon instances', function () {
    $borrowing = new Peminjaman([
        'dipinjam_pada' => '2026-11-13 09:00:00',
        'batas_pengembalian' => '2026-11-20 09:00:00',
        'dikembalikan_pada' => null,
    ]);

    expect($borrowing->dipinjam_pada)->toBeInstanceOf(Carbon::class)
        ->and($borrowing->batas_pengembalian)->toBeInstanceOf(Carbon::class)
        ->and($borrowing->dikembalikan_pada)->toBeNull();
});
