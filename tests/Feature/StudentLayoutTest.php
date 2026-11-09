<?php

it('reuses the branded student layout across library pages', function () {
    foreach ([
        route('student.dashboard'),
        route('student.status'),
        route('student.history'),
        route('student.book.show', 1),
    ] as $url) {
        $this->get($url)
            ->assertSee('PerPusKu')
            ->assertSee('Keluar');
    }
});

it('renders the available book cards on the student dashboard', function () {
    $this->get(route('student.dashboard'))
        ->assertSee('Matematika SMA/SMK Kelas X')
        ->assertSee('Tersedia');
});
