<?php
namespace pwframe\lib\frame\model;

use pwframe\lib\frame\ioc\BeanSingleton;
abstract class ServiceBase implements BeanSingleton {
    public function diDefinition() {
        return array();
    }
}