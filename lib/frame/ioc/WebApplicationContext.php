<?php
namespace pwframe\lib\frame\ioc;

use Closure;
use Exception;
use ReflectionClass;

class WebApplicationContext {
    
    private static $instance;
    private $beanArray = array();
    
    private function __construct() {
        
    }
    
    public static function getInstance() {
        if(null == self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function containsBean($key) {
        return key_exists($key, $this->beanArray);
    }
    
    public function getBean($key) {
        if($this->containsBean($key)) {
            $value = $this->beanArray[$key];
            if(is_object($value) && $value instanceof Closure) return $value();
            return $value;
        }
        try {
            $class = new ReflectionClass($key);
        } catch (Exception $e) {
            return null;
        }
        $instance = $class->newInstanceArgs(); // 暂不支持构造函数参数
        if(!$class->implementsInterface(BeanBase::class)) return $instance;
        $diArray = $instance->diDefinition();
        foreach ($diArray as $diKey => $diValue) {
            $instance->$diKey = $this->getBean($diValue);
        }
        if($class->implementsInterface(BeanSingleton::class)) {
            $this->setBean($key, $instance);
        }
        return $instance;
    }
    
    public function setBean($key, $value) {
        $this->beanArray[$key] = $value;
    }
}