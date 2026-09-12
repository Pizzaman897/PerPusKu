<?php

it('loads the admin borrowing status page without undefined array keys', function () {
    $response = $this->get('/admin/status');

    $response->assertOk();
});
