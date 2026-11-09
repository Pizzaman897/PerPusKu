<?php

it('renders the student list with PerPusKu navigation and sample records', function () {
    $this->get(route('admin.murid.index'))
        ->assertSee('PerPusKu')
        ->assertSee('Kelola Murid')
        ->assertSee('Andi Pratama')
        ->assertSee('Siti Rahmawati')
        ->assertSee('#1')
        ->assertSee('221002');
});

it('renders the student creation form inside the admin layout', function () {
    $this->get(route('admin.murid.create'))
        ->assertSee('PerPusKu')
        ->assertSee('Tambah murid')
        ->assertSee('Kata sandi awal')
        ->assertSee('Konfirmasi kata sandi')
        ->assertSee('Simpan data murid');
});

it('prefills the edit form with the selected sample student', function () {
    $this->get(route('admin.murid.edit', 2))
        ->assertSee('Siti Rahmawati')
        ->assertSee('siti.rahmawati@example.com')
        ->assertSee('221002')
        ->assertSee('Kata sandi baru');
});

it('shows student details and returns not found for an unknown student', function () {
    $this->get(route('admin.murid.show', 1))
        ->assertSee('Andi Pratama')
        ->assertSee('andi.pratama@example.com')
        ->assertSee('221001')
        ->assertSee('Dibuat pada')
        ->assertSee('Diperbarui pada');

    $this->get(route('admin.murid.show', 99))->assertNotFound();
});

it('limits student NIS fields to six characters', function () {
    $this->get(route('admin.murid.create'))
        ->assertSee('name="nis"', false)
        ->assertSee('maxlength="6"', false);

    $this->get(route('admin.murid.edit', 1))
        ->assertSee('name="nis"', false)
        ->assertSee('maxlength="6"', false);
});
