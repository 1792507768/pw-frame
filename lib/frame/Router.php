<?php
namespace pwframe\lib\frame;

class Router {
    
    private static $instance;
    
    private function __construct() {}
    
    public static function getInstance() {
        if(null == self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function parse($appUri, $config) {
        $route = array(
            'module' => 'frontend',
            'controller' => $config['defaultControllerName'],
            'action' => $config['defaultActionName'],
            'paramString' => ''
        );
        $uri = $_SERVER['REQUEST_URI'];
        if(!preg_match('/^[\\/_a-zA-Z\\d\\-]*$/', $uri)) return null;
        if('/' != substr($uri, -1)) $uri .= '/';
        $length = strlen($appUri);
        if(strlen($uri) < $length) return null;
        $uri = trim(substr($uri, $length), '/');
        if(empty($uri)) return $route;
        $uriArray = explode('/', $uri);
        $length = count($uriArray);
        $route['controller'] = $uriArray[0];
        if(1 == $length) return $route;
        $route['action'] = $uriArray[1];
        if(2 == $length) return $route;
        if(empty($config['allowPathParams'])) return null;
        $route['paramString'] = implode('/', array_slice($uriArray, 2));
        return $route;
    }
    
}