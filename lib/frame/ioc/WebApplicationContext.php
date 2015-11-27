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
        if(!$class->implementsInterface(BeanBase::class)) {
            return $class->newInstanceWithoutConstructor();
        }
        $constructor = $class->getConstructor();
        if(null == $constructor) {
            $instance = $class->newInstanceWithoutConstructor();
        } else {
            $parameters = $constructor->getParameters();
            $args = array();
            foreach ($parameters as $parameter) {
                $parameterClass = $parameter->getClass();
                $value = $parameterClass ? $this->getBean($parameterClass->getName()) : null;
                if(null === $value && $parameter->isDefaultValueConstant()) {
                    $value = @constant($parameter->getDefaultValueConstantName());
                }
                if(null === $value && $parameter->isDefaultValueAvailable()) {
                    $value = $parameter->getDefaultValue();
                }
                array_push($args, $value);
            }
            $instance = $class->newInstanceArgs($args);
        }
        if($class->implementsInterface(BeanPrototype::class)) return $instance;
        if($class->implementsInterface(BeanSingleton::class)) {
            $this->setBean($key, $instance);
            return $instance;
        }
        return null; // 不允许直接实现BeanBase
    }
    
    public function setBean($key, $value) {
        $this->beanArray[$key] = $value;
    }
}