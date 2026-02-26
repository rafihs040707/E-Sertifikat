<?php

function can($permission)
{
    $role = $_SESSION['role'] ?? '';

    // Superadmin selalu full akses
    if ($role === 'superadmin') {
        return true;
    }

    $permissions = [
        'admin' => [
            'sertifikat.view',
            'sertifikat.create',
            'sertifikat.edit',

            'pelatihan.view',
            'pelatihan.create',
            'pelatihan.edit',

            'template.view',

            'user.view',
            'user.create',
            'user.edit',
            'user.search'
        ]
    ];

    return in_array($permission, $permissions[$role] ?? []);
}