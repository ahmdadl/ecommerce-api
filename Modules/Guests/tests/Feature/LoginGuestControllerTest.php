<?php

use function Pest\Laravel\post;

test('guest_can_login', function () {
    $response = post(route('api.guests.login'))->assertOk();

    $response->assertSee('access_token');
    $response->assertSee('totals');
});
