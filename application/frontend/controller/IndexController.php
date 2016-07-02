<?php
namespace pwframe\application\frontend\controller;

use pwframe\lib\core\component\CoreController;
use pwframe\model\service\DemoService;
use pwframe\lib\frame\ioc\BeanPrototype;
use pwframe\lib\utils\ApiUtil;

class IndexController extends CoreController implements BeanPrototype {
    
    public $demoSerivce;
    
    public function __construct(DemoService $demoService) {
        $this->demoSerivce = $demoService;
    }

    public function indexAction() {
        $this->assign('message', $this->demoSerivce->getMessage());
        return $this->displayTemplate();
    }
    
    public function newsAction() {
        return ApiUtil::echoResult(0, 'news working!', intval($this->getParam('id')));
    }
    
    public function modifyAction() {
        $result = $this->demoSerivce->insert([
            'name' => 'Node'.time(),
            'status' => 1
        ]);
        if(!$result) {
            return ApiUtil::echoResult(500);
        }
        return ApiUtil::echoResult(0, null, $result);
    }
    
    public function listAction() {
        $data = $this->demoSerivce->getList();
        return ApiUtil::echoResult(0, null, $data);
    }
}