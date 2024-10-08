<?php
return [
    'status' => [
        'inactive' => [
            'id' => 0,
            'name' => 'In-Active'
        ],
        'active' => [
            'id' => 1,
            'name' => 'Active'
        ],
        'deleted' => [
            'id' => 2,
            'name' => 'Deleted'
        ]
    ],
    'courseTypes' => [
        'one_time' => [
            'id' => 1,
            'name' => 'One-time Purchase',
            'access' => 12 //months
        ],
        'variable_access' => [
            'id' => 0,
            'name' => 'Variable Access Duration'
        ],
    ],
    'enrolTypes' => [
        'buy_now' => [
            'id' => 1,
            'name' => 'Buy Now'
        ],
        'add_to_cart' => [
            'id' => 0,
            'name' => 'Add To Cart'
        ],
    ],
    'permissionTypes' => [
        'menu' => [
            'id' => 1,
            'name' => 'Menu'
        ],
        'url' => [
            'id' => 0,
            'name' => 'URL'
        ],
    ],
    'panelTypes' => [
        'menu' => [
            'id' => 1,
            'name' => 'Admin'
        ],
        'url' => [
            'id' => 0,
            'name' => 'Student'
        ],
    ],
    'materialTypes' => [
        'reading' => [
            'id' => 1,
            'name' => 'Reading'
        ],
        'video' => [
            'id' => 0,
            'name' => 'Video'
        ],
        'ppt' => [
            'id' => 2,
            'name' =>'PPT'
        ],
    ],
    'questionType' => [
        'mcq' => [
            'id' => 1,
            'name' => 'MCQ Question'
        ],
        'short' => [
            'id' => 0,
            'name' => 'Short Question'
        ],
    ],
];
