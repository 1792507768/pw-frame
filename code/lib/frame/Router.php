<?php
namespace pwframe\lib\frame;

use \Closure;
use \Exception;
use \ReflectionClass;
use pwframe\lib\frame\exception\ApplicationException;
use pwframe\lib\frame\ioc\WebApplicationContext;

class Router {
    
    private static $instance;
    private static $routes = [];
    private static $domains = ['*' => 'frontend'];
    
    private function __construct() {}
    
    public static function getInstance() {
        if(null == self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public static function init($domains) {
        self::$domains = $domains;
    }
    
    public static function get($uri, $action = null) {
        return self::addRoute(['GET', 'HEAD'], $uri, $action);
    }
    
    public static function post($uri, $action = null) {
        return self::addRoute('POST', $uri, $action);
    }
    
    public static function put($uri, $action = null) {
        return self::addRoute('PUT', $uri, $action);
    }
    
    public static function patch($uri, $action = null) {
        return self::addRoute('PATCH', $uri, $action);
    }
    
    public static function delete($uri, $action = null) {
        return self::addRoute('DELETE', $uri, $action);
    }
    
    public static function options($uri, $action = null) {
        return self::addRoute('OPTIONS', $uri, $action);
    }
    
    public static function any($uri, $action = null) {
        $verbs = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE'];
        return self::addRoute($verbs, $uri, $action);
    }
    
    public static function match($methods, $uri, $action = null) {
        return self::addRoute(array_map('strtoupper', (array) $methods), $uri, $action);
    }
    
    protected static function addRoute($methods, $uri, $action) {
        if(is_scalar($methods)) $methods = [$methods];
        $route = [
            'methods' => $methods,
            'uri' => $uri,
            'action' => $action
        ];
        array_push(self::$routes, $route);
        return true;
    }
    
    public static function generateRoute($controllerName, $actionName, $params = []) {
        return [
            'controller' => $controllerName,
            'action' => $actionName,
            'params' => $params
        ];
    }
    
    public function parseModule($host) {
        foreach (self::$domains as $domain => $module) {
            $domain = str_replace('.', '\.', $domain);
            $domain = str_replace('*', '.+', $domain);
            $domain = '/^'.$domain.'$/';
            if(preg_match($domain, $host)) return $module;
        }
        return null;
    }
    
    public function parseRoute($uri) {
        foreach (self::$routes as $route) {
            $route['uri'] = str_replace('.', '\.', $route['uri']);
            $route['uri'] = str_replace('/', '\/', $route['uri']);
            $route['uri'] = preg_replace('/{\w+}/', '(.*?)', $route['uri']);
            $route['uri'] = '/^'.$route['uri'].'$/';
            if(!preg_match($route['uri'], $uri, $matches)) continue ;
            if(!$route['action'] instanceof Closure) return null;
            return call_user_func_array($route['action'], array_slice($matches, 1));
        }
        return null;
    }
    
    public function conventionRoute($uri, $config) {
        $route = self::generateRoute($config['defaultControllerName'], $config['defaultActionName']);
        $uri = trim($uri, '/');
        if(empty($uri)) return $route;
        $uriArray = explode('/', $uri);
        $length = count($uriArray);
        $route['controller'] = $uriArray[0];
        if(1 == $length) return $route;
        $route['action'] = $uriArray[1];
        if(2 == $length) return $route;
        if(empty($config['allowPathParams']) || $length % 2 != 0) return null;
        for ($i = 2; $i < $length; $i += 2) {
            $route['params'][$uriArray[$i]] = $uriArray[$i + 1];
        }
        return $route;
    }
    
    private function invoke(Application $app, $module, $route, $args = null) {
        $config = $app->getApplicationConfig();
        $webApplicationContext = WebApplicationContext::getInstance();
        $className = $app->getRootNamespace().$app->getApplicationDirectory().'\\'.$module."\\controller"
            .'\\'.ucfirst($route['controller']).$config['defaultControllerSuffix'];
        $instance = $webApplicationContext->getBean($className);
        try {
            $controller = new ReflectionClass($instance);
            $instance->setAppUrl($app->getAppUrl());
            $instance->setAppUri($app->getAppUri());
            $instance->setAppPath($app->getAppPath());
            $instance->setRootPath($app->getRootPath());
            $instance->setModuleName($module);
            $instance->setControllerName($route['controller']);
            $instance->setActionName($route['action']);
            if(!is_array($route['params'])) $route['params'] = [];
            $route['params'] = array_merge($_REQUEST, $route['params']);
            $instance->setParams($route['params']);
            $instance->setAssign([]);
            $initVal = $instance->init();
            if (null !== $initVal) return new ApplicationException('initError');
            $action = $controller->getMethod($route['action'].$config['defaultActionSuffix']);
            if (null === $args) {
                $actionVal = $action->invoke($instance);
            } else {
                $actionVal = $action->invoke($instance, $args);
            }
            $destroyVal = $instance->destroy($actionVal);
            if (null !== $destroyVal) return new ApplicationException('destroyError');
        } catch (Exception $e) {
            return new Exception('Route:controller['.$route['controller'].'] - action['.$route['action'].']', null, $e);
        }
        return null;
    }
    
    public function dispatch(Application $app) {
        $config = $app->getApplicationConfig();
        // 模块检测
        $host = explode(':', $_SERVER['HTTP_HOST'])[0];
        $module = $this->parseModule($host);
        if(null == $module) return new ApplicationException('no module matches!');
        // 载入模块初始化文件
        $filename = $app->getRootPath().$app->getApplicationDirectory()
            .DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'init.php';
        if(file_exists($filename)) include_once $filename;
        // URI检测
        $uri = $_SERVER['REQUEST_URI'];
        if(0 !== strpos($uri, $app->getAppUri())) return new ApplicationException('app uri error!');
        $uri = '/'.substr($uri, strlen($app->getAppUri()));
        // 自定义路由检测
        $route = $this->parseRoute($uri);
        // 约定路由检测
        if(null == $route) $route = $this->conventionRoute($uri, $config);
        // 执行路由
        $retVal = $this->invoke($app, $module, $route);
        if(null === $retVal) return null;
        // 执行路由失败，调用错误处理
        $route = self::generateRoute($config['defaultErrorController'], $config['defaultErrorAction']);
        return $this->invoke($app, $module, $route, $retVal);
    }
    
}