<?php
namespace pwframe\lib\frame\model;

use pwframe\lib\frame\ioc\BeanPrototype;

abstract class DaoBase implements BeanPrototype {
    public function diDefinition() {
        return array();
    }
}