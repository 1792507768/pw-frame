<?php
namespace pwframe\model\service;

use pwframe\lib\frame\mvc\ServiceBase;
use pwframe\lib\frame\ioc\BeanSingleton;
use pwframe\model\dao\DemoDao;
use pwframe\lib\frame\ioc\WebApplicationContext;

class DemoService extends ServiceBase implements BeanSingleton {
    
    protected $webApplicationContext;
    
    public function __construct(WebApplicationContext $webApplicationContext) {
        $this->webApplicationContext = $webApplicationContext;
    }
    
    public function insert($data) {
        $demoDao = $this->webApplicationContext->getBean(DemoDao::class);
        return $demoDao->insert($data);
    }
    
    public function getList() {
        $demoDao = $this->webApplicationContext->getBean(DemoDao::class);
        return $demoDao->where(['status' => 1])->orderBy('id desc')->limit(30)->all();
    }
    
    public function getMessage() {
        return 'it works!';
    }
}