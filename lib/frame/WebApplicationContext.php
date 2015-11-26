<?php
namespace pwframe\lib\frame;

class WebApplicationContext {
    
    private static $instance;
    
    private function __construct() {
        
    }
    
    public static function getInstance() {
        if(null == self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function containsBean() {
        
    }
    
    public function getBean() {
        
    }
    
    public function setBean() {
        
    }
}