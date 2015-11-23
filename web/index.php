<?php
define('DEBUG', true);

use pwframe\lib\frame\Application;

require_once __DIR__.'/../lib/frame/Application.php';

try {
    $app = new Application('/', __DIR__);
    $app->run();
} catch (Exception $e) {
    if(DEBUG) throw $e;
}