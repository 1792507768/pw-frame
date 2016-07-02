<?php
define('DEBUG', true);

use \Exception;
use pwframe\lib\frame\Application;

require_once __DIR__.'/../lib/frame/Application.php';

try {
    $app = new Application('/', __DIR__);
    $result = $app->run();
    if(null !== $result) throw Exception($result);
} catch (Exception $e) {
    if(DEBUG) throw $e;
}