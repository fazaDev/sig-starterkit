<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Permission Groups
    |--------------------------------------------------------------------------
    |
    | Human readable labels for the permission groups. Group keys are used by
    | the role form to render permissions in a logical order.
    |
    */

    'groups' => [
        'dashboard' => 'Dashboard',
        'users' => 'Manajemen Pengguna',
        'roles' => 'Manajemen Role',
    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    |
    | Permissions are defined here so the seeder and the role form always stay
    | in sync. The admin panel only assigns these permissions to roles; it does
    | not create new permission records.
    |
    */

    'permissions' => [
        'dashboard.view' => [
            'group' => 'dashboard',
            'label' => 'Melihat dashboard',
        ],
        'users.view' => [
            'group' => 'users',
            'label' => 'Melihat daftar pengguna',
        ],
        'users.create' => [
            'group' => 'users',
            'label' => 'Menambah pengguna',
        ],
        'users.update' => [
            'group' => 'users',
            'label' => 'Mengubah pengguna',
        ],
        'users.delete' => [
            'group' => 'users',
            'label' => 'Menghapus pengguna',
        ],
        'roles.view' => [
            'group' => 'roles',
            'label' => 'Melihat daftar role',
        ],
        'roles.create' => [
            'group' => 'roles',
            'label' => 'Menambah role',
        ],
        'roles.update' => [
            'group' => 'roles',
            'label' => 'Mengubah role',
        ],
        'roles.delete' => [
            'group' => 'roles',
            'label' => 'Menghapus role',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    |
    | Default roles seeded into the application. A permission value of "*"
    | grants every permission defined above. Roles marked as locked cannot be
    | renamed or deleted from the admin panel.
    |
    */

    'roles' => [
        'admin' => [
            'label' => 'Administrator',
            'description' => 'Akses penuh ke seluruh fitur aplikasi.',
            'locked' => true,
            'permissions' => '*',
        ],
        'staff' => [
            'label' => 'Staff',
            'description' => 'Akses terbatas untuk melihat dashboard dan pengguna.',
            'locked' => false,
            'permissions' => [
                'dashboard.view',
                'users.view',
            ],
        ],
    ],

];
