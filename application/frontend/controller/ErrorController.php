<?php
namespace pwframe\application\frontend\controller;

use pwframe\lib\core\component\CoreController;

class ErrorController extends CoreController {
    public function indexAction($e) {
        echo 'something error!';
        var_dump($e);
    }
}