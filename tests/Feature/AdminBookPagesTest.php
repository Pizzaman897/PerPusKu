<?php

it('renders book details with the shared admin layout', function () {
    $this->get(route('admin.buku.show', 1))
        ->assertSee('PerPusKu')
        ->assertSee('Gajah Minum Air')
        ->assertSee('Kisah ringan tentang petualangan dan persahabatan.')
        ->assertSee('Tersedia')
        ->assertSee('ID Buku')
        ->assertSee('Dibuat pada')
        ->assertSee('Diperbarui pada');
});

it('shows book identifiers in the collection list and keeps availability derived', function () {
    $this->get(route('admin.buku.index'))
        ->assertSee('#1')
        ->assertSee('#2');

    $this->get(route('admin.buku.create'))
        ->assertSee('Status awal buku otomatis')
        ->assertDontSee('name="status"', false);
});

it('returns not found for an unknown sample book', function () {
    $this->get(route('admin.buku.show', 99))->assertNotFound();
});
