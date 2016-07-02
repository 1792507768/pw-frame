<?php
use pwframe\lib\frame\Router;

Router::get('/news/{id}.shtml', function ($id) {
    return Router::generateRoute('index', 'news', ['id' => $id]);
});