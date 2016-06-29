<?php
namespace pwframe\model\service;

use pwframe\lib\frame\mvc\ServiceBase;
use pwframe\lib\frame\ioc\BeanSingleton;

class DemoService extends ServiceBase implements BeanSingleton {
    
    public function getMessage() {
        return 'it works!';
    }
}