<?php
namespace pwframe\application\backend\controller;

use pwframe\lib\core\component\CoreController;
use pwframe\model\service\DemoService;
use pwframe\lib\frame\ioc\BeanPrototype;

class IndexController extends CoreController implements BeanPrototype {
    
    public $demoSerivce;
    
    public function __construct(DemoService $demoService) {
        $this->demoSerivce = $demoService;
    }

    public function indexAction() {
        $this->assign('message', $this->demoSerivce->getMessage());
        return $this->displayTemplate();
    }
}