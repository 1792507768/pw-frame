<?php
define('DEBUG', true);

use \Exception;
use pwframe\lib\frame\Application;
use pwframe\lib\frame\Router;

require_once __DIR__.'/../lib/frame/Application.php';

try {
    $app = new Application('/', __DIR__);
    Router::init([ // 配置域名目录映射
        'pw-frame.iisquare.com' => 'backend',
        '*' => 'frontend'
    ]);
    $result = $app->run();
    if(null !== $result) throw Exception(strval($result));
} catch (Exception $e) {
    if(DEBUG) throw $e;
}