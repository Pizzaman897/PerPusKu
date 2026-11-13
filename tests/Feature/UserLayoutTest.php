<?php

it('reuses the branded user layout across library pages', function () {
    foreach ([
        route('user.dashboard'),
        route('user.status'),
        route('user.history'),
        route('user.book.show', 1),
    ] as $url) {
        $this->get($url)
            ->assertSee('PerPusKu')
            ->assertSee('Keluar');
    }
});

it('renders the available book cards on the user dashboard', function () {
    $this->get(route('user.dashboard'))
        ->assertSee('Matematika SMA/SMK Kelas X')
        ->assertSee('Tersedia');
});
