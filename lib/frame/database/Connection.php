<?php
namespace pwframe\lib\frame\database;

use pwframe\lib\frame\ioc\WebApplicationContext;
use pwframe\lib\frame\Application;
use pwframe\lib\frame\Logger;

abstract class Connection {
    
    private $config;
    protected $logger;
    
    public function __construct() {
        $this->logger = Logger::getInstance();
    }
    
    protected function loadConfig($dbType) {
        if(null == $this->config) {
            /**
             * @var Application $app
             */
            $app = WebApplicationContext::getInstance()->getBean(Application::class);
            $this->config = require_once $app->getRootPath().$app->getConfigDirectory().DIRECTORY_SEPARATOR.'db.config.php';
        }
        if(null == $dbType) return $this->config;
        if(isset($this->config[$dbType])) return $this->config[$dbType];
        return null;
    }
    
}