<?php

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('loads the admin borrowing status page without undefined array keys', function () {
    $response = $this->actingAs(new Admin(['name' => 'Admin']), 'admin')
        ->get('/admin/status');

    $response->assertOk();
});
