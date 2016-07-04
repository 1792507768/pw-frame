<?php
namespace pwframe\lib\core\component;

use pwframe\lib\frame\mvc\ControllerBase;

abstract class CoreController extends ControllerBase {
    
    public function displayTemplate($action = null, $controller = null) {
        $this->assign('appUrl', $this->appUrl);
        return parent::displayTemplate($action, $controller);
    }
    
}