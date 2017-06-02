<?php
namespace pwframe\model\service;

use pwframe\lib\frame\mvc\ServiceBase;
use pwframe\lib\frame\ioc\BeanSingleton;
use pwframe\model\dao\DemoDao;

class DemoService extends ServiceBase implements BeanSingleton {
    
    public function __construct() {
    }
    
    public function insert($data) {
        $demoDao = new DemoDao();
        return $demoDao->insert($data);
    }
    
    public function getList() {
        $demoDao = new DemoDao();
        return $demoDao->where(['status' => 1])->orderBy('id desc')->limit(30)->all();
    }
    
    public function getMessage() {
        return 'it works!';
    }
}