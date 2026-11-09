<?php

it('reuses the branded admin layout across dashboard and book pages', function () {
    foreach ([
        route('admin.dashboard'),
        route('admin.buku.index'),
        route('admin.buku.create'),
        route('admin.buku.edit', 1),
        route('admin.kelola-admin.create'),
    ] as $url) {
        $this->get($url)
            ->assertSee('PerPusKu')
            ->assertSee('Kelola Murid');
    }
});
