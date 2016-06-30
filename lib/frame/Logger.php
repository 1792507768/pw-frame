<?php
namespace pwframe\lib\frame;

class Logger {
    
    const DEBUG = 1; // Level指出细粒度信息事件对调试应用程序是非常有帮助的。 
    const INFO = 2; // Level表明 消息在粗粒度级别上突出强调应用程序的运行过程。 
    const WARN = 4; // Level表明会出现潜在错误的情形。 
    const ERROR = 8; // Level指出虽然发生错误事件，但仍然不影响系统的继续运行。 
    const FATAL = 16; // Level指出每个严重的错误事件将会导致应用程序的退出。 
    
    private static $instance;
    private static $level;
    
    public function setLevel($level) {
        self::$level = $level;
        return $this;
    }

    private function __construct() {}
    
    public static function getInstance() {
        if(null == self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function debug($msg) {
        return $this->record(self::DEBUG, $msg);
    }
    
    public function info($msg) {
        return $this->record(self::INFO, $msg);
    }
    
    public function warn($msg) {
        return $this->record(self::WARNA, $msg);
    }
    
    public function error($msg) {
        return $this->record(self::ERROR, $msg);
    }
    
    public function fatal($msg) {
        return $this->record(self::FATAL, $msg);
    }
    
    private function record($level, $msg) {
        if(self::$level) {
            echo $msg;
        }
        return true;
    }
}