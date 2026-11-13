<?php

it('renders the registration page', function () {
    $this->get(route('register'))
        ->assertSee('Buat Akun Anda');
});
