<?php
namespace pwframe\lib\frame\mvc;

use pwframe\lib\frame\Logger;
use pwframe\lib\frame\ioc\BeanPrototype;

abstract class DaoBase implements BeanPrototype {
    
    protected $logger;
    
    public function __construct() {
        $this->logger = Logger::getInstance();
    }
    
}