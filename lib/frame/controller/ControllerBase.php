<?php
namespace pwframe\lib\frame\controller;

use pwframe\lib\frame\ioc\BeanPrototype;

abstract class ControllerBase implements BeanPrototype {
    protected $webApplicationContext;
    protected $appUri, $appUrl, $appPath, $rootPath;
    protected $controllerName, $actionName;
    protected $params; // 请求参数
    protected $assign; // 视图数据Map对象

    public function getWebApplicationContext() {
        return $this->webApplicationContext;
    }

    public function setWebApplicationContext($webApplicationContext) {
        $this->webApplicationContext = $webApplicationContext;
    }

    public function getAppUri() {
        return $this->appUri;
    }

    public function getAppUrl() {
        return $this->appUrl;
    }

    public function getAppPath() {
        return $this->appPath;
    }

    public function getRootPath() {
        return $this->rootPath;
    }

    public function getControllerName() {
        return $this->controllerName;
    }

    public function getActionName() {
        return $this->actionName;
    }

    public function getParams() {
        return $this->params;
    }

    public function getAssign() {
        return $this->assign;
    }

    public function setAppUri($appUri) {
        $this->appUri = $appUri;
    }

    public function setAppUrl($appUrl) {
        $this->appUrl = $appUrl;
    }

    public function setAppPath($appPath) {
        $this->appPath = $appPath;
    }

    public function setRootPath($rootPath) {
        $this->rootPath = $rootPath;
    }

    public function setControllerName($controllerName) {
        $this->controllerName = $controllerName;
    }

    public function setActionName($actionName) {
        $this->actionName = $actionName;
    }

    public function setParams($params) {
        $this->params = $params;
    }

    public function setAssign($assign) {
        $this->assign = $assign;
    }
    
    public function init() {
        return null;
    }
    
    public function destroy($actionVal) {
        return $actionVal;
    }
    
    public function diDefinition() {
        return array();
    }
    
    /**
     * 设置视图中需要的参数
     */
    protected function assign($key, $value) {
        $this->assign[$key] = $value;
        return $this;
    }
    
    protected function url($action = null, $controller = null) {
        if(null == $controller) $controller = $this->controllerName;
        if(null == $action) $action = $this->actionName;
        return $this->appPath.$controller.'/'.$action.'/';
    }
    
    protected function displayTemplate($action = null, $controller = null) {
        if(null == $controller) $controller = $this->controllerName;
        if(null == $action) $action = $this->actionName;
        extract($this->assign);
        include $this->rootPath.'application'.DIRECTORY_SEPARATOR
            .'view'.DIRECTORY_SEPARATOR.$controller.DIRECTORY_SEPARATOR.$action.'.php';
        return null;
    }
    
    /**
     * 重定向自定义URL地址
     */
    protected function redirect($url) {
        header('Location:'.$url);
        return null;
    }
}