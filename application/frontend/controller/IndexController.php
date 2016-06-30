<?php
namespace pwframe\application\frontend\controller;

use pwframe\lib\core\component\CoreController;
use pwframe\model\service\DemoService;
use pwframe\lib\frame\ioc\BeanPrototype;
use pwframe\lib\frame\database\MySQLConnection;

class IndexController extends CoreController implements BeanPrototype {
    
    public $demoSerivce;
    
    public function __construct(DemoService $demoService) {
        $this->demoSerivce = $demoService;
    }

    public function indexAction() {
        MySQLConnection::getInstance()->getResource(false);
        $this->assign('message', $this->demoSerivce->getMessage());
        return $this->displayTemplate();
    }
}