<?php
namespace pwframe\lib\frame;

use pwframe\lib\frame\ioc\WebApplicationContext;
use pwframe\lib\frame\exception\ApplicationException;

class Application {
    
    public static $useComposer = false; // 是否使用Composer
    private $autoloadExtension = '.php'; // 文件后缀
    private $rootNamespace = 'pwframe\\'; // 根命名空间
    private $webDirectory = 'web'; // Web目录
    private $applicationDirectory = 'application'; // Application目录
    private $configDirectory = 'config'; // 配置文件目录
    private $appUri, $appUrl, $appPath, $rootPath;
    private $applicationConfig, $webApplicationContext;
    
    public function getAutoloadExtension(){
        return $this->autoloadExtension;
    }

    public function getRootNamespace() {
        return $this->rootNamespace;
    }

    public function getWebDirectory() {
        return $this->webDirectory;
    }

    public function getApplicationDirectory() {
        return $this->applicationDirectory;
    }

    public function getConfigDirectory() {
        return $this->configDirectory;
    }

    public function getAppUri() {
        return $this->appUri;
    }

    public function getAppUrl() {
        return $this->appUrl;
    }

    public function getAppPath() {
        return $this->appPath;
    }

    public function getRootPath() {
        return $this->rootPath;
    }

    public function getApplicationConfig() {
        return $this->applicationConfig;
    }

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
        date_default_timezone_set('Asia/Shanghai');
        if(defined('DEBUG') && true === DEBUG) {
            ini_set('display_errors', 'On');
            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', 'Off');
            error_reporting(0);
        }
        if(self::$useComposer) {
            require __DIR__.'/../../vendor/autoload.php';
        } else {
            spl_autoload_extensions($this->autoloadExtension);
        }
        spl_autoload_register([$this, 'autoload']);
        $this->applicationConfig = require_once $this->rootPath.$this->configDirectory.DIRECTORY_SEPARATOR.'application.config.php';
        $this->webApplicationContext = WebApplicationContext::getInstance();
        $this->webApplicationContext->setBean(self::class, function () { // WebApplicationContext对象
            return $this;
        });
        $this->webApplicationContext->setBean(Session::class, function () { // Session对象
            return Session::getInstance();
        });
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
        return Router::getInstance()->dispatch($this);
    }
    
}
