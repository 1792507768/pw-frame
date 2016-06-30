<?php
return [
    'mysql' => [
        'tablePrefix' => 't_',
        'master' => [
            'host' => '127.0.0.1',
            'port' => '3306',
            'dbname' => 'pwframe',
            'username' => 'root',
            'password' => 'admin888',
            'charset' => 'utf8'
        ],
        'slaves' => [
            'salve1' => [
                'host' => '127.0.0.2',
                'port' => '3306',
                'dbname' => 'pwframe',
                'username' => 'root',
                'password' => 'admin888',
                'charset' => 'utf8'
            ],
            'salve2' => [
                'host' => '127.0.0.3',
                'port' => '3306',
                'dbname' => 'pwframe',
                'username' => 'root',
                'password' => 'admin888',
                'charset' => 'utf8'
            ]
        ]
    ]
];