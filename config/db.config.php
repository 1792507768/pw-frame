<?php
return [
    'type' => 'mysql',
    'tablePrefix' => 't_',
    'master' => [
        'host' => '127.0.0.1',
        'port' => '3306',
        'dbname' => 'pwframe',
        'username' => 'root',
        'password' => 'admin888',
        'charset' => 'utf8'
    ],
    'salves' => [
        'salve1' => [
            'host' => '127.0.0.1',
            'port' => '3306',
            'dbname' => 'test',
            'username' => 'root',
            'password' => 'admin888',
            'charset' => 'utf8'
        ],
        'salve2' => [
            'host' => '127.0.0.1',
            'port' => '3306',
            'dbname' => 'pwframe',
            'username' => 'root',
            'password' => 'admin888',
            'charset' => 'utf8'
        ]
    ]
];