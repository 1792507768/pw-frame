<?php
namespace pwframe\lib\frame\mvc;

use pwframe\lib\frame\Logger;

abstract class DaoBase {
    
    protected $logger;
    
    public function __construct() {
        $this->logger = Logger::getInstance();
    }
    
}