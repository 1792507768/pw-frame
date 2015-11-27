<?php
namespace pwframe\application\controller;

use pwframe\lib\core\component\CoreController;

class IndexController extends CoreController {
    public function indexAction() {
        $this->assign('message', 'it works');
        return $this->displayTemplate();
    }
}