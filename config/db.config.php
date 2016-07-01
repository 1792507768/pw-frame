<?php
return [
    'mysql' => [
        'dbname' => 'pwframe',
        'username' => 'root',
        'password' => 'admin888',
        'charset' => 'utf8',
        'tablePrefix' => 't_',
        'master' => [
            'host' => '127.0.0.1',
            'port' => '3306'
        ],
        'slaves' => [
            'salve1' => [
                'host' => '127.0.0.2',
                'port' => '3306'
            ],
            'salve2' => [
                'host' => '127.0.0.3',
                'port' => '3306'
            ]
        ]
    ]
];