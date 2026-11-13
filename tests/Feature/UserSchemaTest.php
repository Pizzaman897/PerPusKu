<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

it('stores user accounts and borrowing ownership in the renamed schema', function () {
    expect(Schema::hasTable('users'))->toBeTrue()
        ->and(Schema::hasTable('murids'))->toBeFalse()
        ->and(Schema::hasColumn('peminjaman', 'user_id'))->toBeTrue()
        ->and(Schema::hasColumn('peminjaman', 'murid_id'))->toBeFalse();
});
