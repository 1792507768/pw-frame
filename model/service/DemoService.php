<?php
namespace pwframe\model\service;

use pwframe\lib\frame\mvc\ServiceBase;
use pwframe\lib\frame\ioc\BeanSingleton;
use pwframe\model\dao\DemoDao;

class DemoService extends ServiceBase implements BeanSingleton {
    
    private $demoDao;
    
    public function __construct(DemoDao $demoDao) {
        $this->demoDao = $demoDao;
    }
    
    public function insert($data) {
        return $this->demoDao->insert($data);
    }
    
    public function getList() {
        return $this->demoDao->where(['status' => 1])->orderBy('id desc')->limit(30)->all();
    }
    
    public function getMessage() {
        return 'it works!';
    }
}