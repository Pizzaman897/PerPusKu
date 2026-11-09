<?php

it('shows borrowing identifiers, deadlines, timestamps, and statuses', function () {
    $this->get(route('admin.status.index'))
        ->assertSee('#1')
        ->assertSee('#2')
        ->assertSee('Batas kembali')
        ->assertSee('01-09-2026 08:00')
        ->assertSee('08-09-2026')
        ->assertSee('Dikembalikan')
        ->assertSee('Terlambat');
});
