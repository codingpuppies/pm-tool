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

    'developer_column' => '#a5d6a7',
    'action_column' => '#fff59d',
    'EDIT_ESTIMATE_VARIABLE_COST' => '1',
    'EDIT_ACTUAL_VARIABLE_COST' => '2',


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


    'table_column' => [
        '0' => '#2196f3',
        '1' => '#3f51b5',
        '2' => '#ff9800',
        '3' => '#4caf50',
        '4' => '#795548',
        '5' => '#f44336',
        '6' => '#e91e63',
        '7' => '#9c27b0',
        '8' => '#3f51b5',
        '9' => '#03a9f4',
        '10' => '#00bcd4',
        '11' => '#009688',
        '12' => '#4caf50',
        '13' => '#cddc39',
    ],
    'table_est_act' => [
        '0' => [
            '0' => '#e3f2fd',
            '1' => '#90caf9'
        ],
        '1' => [
            '0' => '#e8eaf6',
            '1' => '#7986cb'
        ],
        '2' => [
            '0' => '#fff3e0',
            '1' => '#ffcc80'
        ],
        '3' => [
            '0' => '#e8f5e9',
            '1' => '#c8e6c9'
        ],
        '4' => [
            '0' => '#fffde7',
            '1' => '#fff59d'
        ],
    ],

    /*
    |------------------------------------------------------------------------------------
    | ENV of APP
    |------------------------------------------------------------------------------------
    */
    'APP_ADMIN' => 'admin',
    'APP_TOKEN' => env('APP_TOKEN', 'admin123456'),
];
