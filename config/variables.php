<?php

return [
    
    'boolean' => [
        '0' => 'No',
        '1' => 'Yes',
    ],

    'role' => [
        '0' => 'Developer',
        '1' => 'Quality Assurance',
        '2' => 'Project Manager',
        '10' => 'Admin',
    ],

    'role_code' => [
        'DEVELOPER' => '0',
        'QA' => '1',
        'PM' => '2',
        'ADMIN' => '10',
    ],
    'position' => [
        '0' => 'Developer',
        '1' => 'Quality Assurance',
        '2' => 'Project Manager',
    ],
    'department' => [
        '0' => 'PHP',
        '1' => 'Python',
        '2' => 'Project Management',
    ],
    
    'status' => [
        '1' => 'Active',
        '0' => 'Inactive',
    ],

    'avatar' => [
        'public' => '/storage/avatar/',
        'folder' => 'avatar',
        
        'width'  => 400,
        'height' => 400,
    ],

    'duration' => [
        'ONE_MONTH'  => 1,
        'YEAR' => 12,
    ],

    'project_status' => [
        '0' => 'INACTIVE',
        '1' => 'ACTIVE',
        '2' => 'ON-HOLD',
        '3' => 'CANCELLED',
        '4' => 'COMPLETED',
    ],

    /*
    |------------------------------------------------------------------------------------
    | ENV of APP
    |------------------------------------------------------------------------------------
    */
    'APP_ADMIN' => 'admin',
    'APP_TOKEN' => env('APP_TOKEN', 'admin123456'),
];
