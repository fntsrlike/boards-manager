<?php

return [
    'roles' => [
        'normal'        => 'Normal User',
        'applicant'     => 'Applicant',
        'manager'       => 'Manager',
        'administrator' => 'Administrator'
    ],

    'permissions' => [
        'users_management'             => 'Users Management',
        'boards_management'            => 'Boards Management',
        'apply_records_management'     => 'Apply Record Management',
        'apply_post'                   => 'Apply Post on Boards',
        'report'                       => 'Report Bad Using Situation'
    ],

    'permission_role' => [
        'normal'        => ['report'],
        'applicant'     => ['report', 'apply_post'],
        'manager'       => ['boards_management', 'apply_records_management'],
        'administrator' => ['users_management', 'boards_management', 'apply_records_management'],
    ]
];
