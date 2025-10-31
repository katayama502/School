<?php

use Illuminate\Support\Facades\Route;

test('auth routes are registered', function () {
    expect(Route::has('api.v1.auth.login'))->toBeFalse();
    expect(Route::has('api.v1.auth.logout'))->toBeFalse();
    expect(Route::has('api.v1.auth.me'))->toBeFalse();
});
