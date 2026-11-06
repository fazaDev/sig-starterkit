<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Administrator Account
    |--------------------------------------------------------------------------
    |
    | These values are used by the AdminUserSeeder to create the first admin
    | account. Always override the password in production environments.
    |
    */

    'name' => env('ADMIN_NAME', 'Administrator'),

    'email' => env('ADMIN_EMAIL', 'admin@example.com'),

    'password' => env('ADMIN_PASSWORD', 'password'),

];
