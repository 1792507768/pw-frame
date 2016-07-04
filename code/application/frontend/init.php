<?php
use pwframe\lib\frame\Router;

Router::get('/news/{date}/{id}.shtml', function ($date, $id) {
    return Router::generateRoute('index', 'news', [
        'date' => $date,
        'id' => $id
    ]);
});