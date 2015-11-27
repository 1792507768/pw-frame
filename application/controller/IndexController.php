<?php
namespace pwframe\application\controller;

use pwframe\lib\core\component\CoreController;
use pwframe\application\service\DemoService;

class IndexController extends CoreController {
    
    public $demoSerive;
    
    public function diDefinition() {
        return array(
            'demoSerive' => DemoService::class
        );
    }

    public function indexAction() {
        var_dump($this->demoSerive);
        $this->assign('message', 'it works');
        return $this->displayTemplate();
    }
}