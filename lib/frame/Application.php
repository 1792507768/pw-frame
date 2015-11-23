<?php
namespace pwframe\lib\frame;

use Exception;

class Application {
    private $autoloadExtension = '.php';
    private $rootNamespace = 'pwframe\\';
    private $webDirectory = 'web';
    private $appUri, $appUrl, $appPath, $rootPath;
    
    public function __construct($appUri, $rootPath) {
        if(empty($appUri)) {
            $appUri = '/';
        } else {
            if('/' != substr($appUri, 0, 1)) $appUri = '/'.$appUri;
            if('/' != substr($appUri, -1)) $appUri .= '/';
        }
        $this->appUri = $appUri;
        $this->appUrl = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];
        if(80 != $_SERVER['SERVER_PORT']) $this->appUrl .= ':'.$_SERVER['SERVER_PORT'];
        $this->appPath = $this->appUrl.$this->appUri;
        if(DIRECTORY_SEPARATOR != substr($rootPath, -1)) $rootPath .= DIRECTORY_SEPARATOR;
        $this->rootPath = substr($rootPath, 0, strlen($rootPath) - strlen($this->webDirectory) - 1);
        $this->init();
    }
    
    private function init() {
        spl_autoload_extensions($this->autoloadExtension);
        spl_autoload_register(array($this, 'autoload'));
    }
    
    public function autoload($className) {
        $rootLength = strlen($this->rootNamespace);
        if(strlen($className) < $rootLength) {
            throw new ApplicationException('class namespace error!');
        }
        $className = substr($className, $rootLength);
        $classPath = $this->rootPath.str_replace('\\', DIRECTORY_SEPARATOR, $className).$this->autoloadExtension;
        if(!is_file($classPath)) {
            throw new ApplicationException('can not found class file![className:'.$className.',classPath:'.$classPath.']');
        }
        require_once $classPath;
    }
    
    public function run() {
        
    }
}

class ApplicationException extends Exception {}
