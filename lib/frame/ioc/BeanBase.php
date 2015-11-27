<?php
namespace pwframe\lib\frame\ioc;

interface BeanBase {
    public abstract function diDefinition() {
        return array();
    }
}