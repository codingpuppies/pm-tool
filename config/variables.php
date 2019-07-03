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
        '3' => 'Management',
        '10' => 'Admin',
    ],

    'role_code' => [
        'DEVELOPER' => 0,
        'QA' => 1,
        'PM' => 2,
        'MGT' => 3,
        'ADMIN' => 10,
    ],

    'position' => [
        '0' => 'Developer',
        '1' => 'Quality Assurance',
        '2' => 'Project Manager',
        '3' => 'Manager',
    ],

    'mgt_position' => [
        '3' => 'Manager',
        '4' => 'VP',
        '5' => 'CEO',
        '6' => 'PRESIDENT',
    ],

    'department' => [
        '0' => 'PHP',
        '1' => 'Python',
        '2' => 'Project Management',
        '3' => 'Management',
    ],
    'mgt_department' => [
        '3' => 'Management',
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

    'particulars' => [
        'SALARY' => 'SALARY',
        'RENT' => 'RENT',
        'INTERNET BILL' => 'INTERNET BILL',
        'PHONE BILL' => 'PHONE BILL',
        'ELECTRIC BILL' => 'ELECTRIC BILL',
        'WATER BILL' => 'WATER BILL',
        'FOOD' => 'FOOD',
        'TRAVEL EXPENSES' => 'TRAVEL EXPENSES',
        'MAINTENANCE' => 'MAINTENANCE',
        'OTHERS' => 'OTHERS',
    ],

    /*
    |------------------------------------------------------------------------------------
    | ENV of APP
    |------------------------------------------------------------------------------------
    */
    'APP_ADMIN' => 'admin',
    'APP_TOKEN' => env('APP_TOKEN', 'admin123456'),
];
