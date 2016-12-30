<?php
namespace pwframe\application\backend\controller;

use pwframe\lib\core\component\CoreController;
use pwframe\model\service\DemoService;
use pwframe\lib\frame\ioc\BeanPrototype;
use pwframe\lib\frame\Session;
use pwframe\lib\utils\ApiUtil;

class IndexController extends CoreController implements BeanPrototype {
    
    public $session;
    public $demoSerivce;
    
    public function __construct(Session $session, DemoService $demoService) {
        $this->session = $session;
        $this->demoSerivce = $demoService;
    }

    public function indexAction() {
        $this->assign('message', $this->demoSerivce->getMessage());
        return $this->displayTemplate();
    }
    
    public function sessionAction() {
        $data = $this->session->get('time');
        if(!$data) {
            $data = time();
            $this->session->set('time', $data);
        }
        return ApiUtil::echoResult(0, null, $data);
    }
    
}