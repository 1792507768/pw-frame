<?php
namespace pwframe\lib\frame\controller;

class ControllerBase {
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
}