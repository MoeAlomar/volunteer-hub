<?php

use App\Models\Admin;
use App\Models\User;

return [

    // The admin guard is the only login in this app, so it is the default.
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'admin'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => ['driver' => 'session', 'provider' => 'users'],
        'admin' => ['driver' => 'session', 'provider' => 'admins'],
    ],

    'providers' => [
        'users' => ['driver' => 'eloquent', 'model' => User::class],
        'admins' => ['driver' => 'eloquent', 'model' => Admin::class],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
