<?php
namespace pwframe\lib\frame;

class Logger {
    
    const TRACE = 1; // 详细跟踪日志
    const DEBUG = 2; // 调试日志
    const INFO = 4; // 粗粒度日志
    const WARN = 8; // 警告日志
    const ERROR = 16; // 错日日志
    const FATAL = 32; // 严重错误
    
    private static $instance;
    private static $level = 1024;
    
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
    
    public function isTraceEnabled() {
		return self::TRACE >= self::$level;
	}
	
	public function isDebugEnabled() {
		return self::DEBUG >= self::$level;
	}

	public function isInfoEnabled() {
		return self::INFO >= self::$level;
	}
	
	public function isWarnEnabled() {
		return self::WARN >= self::$level;
	}
	
	public function isErrorEnabled() {
		return self::ERROR >= self::$level;
	}
	
	public function isFatalEnabled() {
		return self::FATAL >= self::$level;
	}
    
	public function trace($msg) {
	    return $this->log(self::TRACE, $msg);
	}
	
    public function debug($msg) {
        return $this->log(self::DEBUG, $msg);
    }
    
    public function info($msg) {
        return $this->log(self::INFO, $msg);
    }
    
    public function warn($msg) {
        return $this->log(self::WARNA, $msg);
    }
    
    public function error($msg) {
        return $this->log(self::ERROR, $msg);
    }
    
    public function fatal($msg) {
        return $this->log(self::FATAL, $msg);
    }
    
    private function log($level, $msg) {
        switch ($level) {
            case self::TRACE:
                $title = 'TRACE';
                break;
            case self::DEBUG:
                $title = 'DEBUG';
                break;
            case self::INFO:
                $title = 'DEBUG';
                break;
            case self::WARNA:
                $title = 'DEBUG';
                break;
            case self::ERROR:
                $title = 'DEBUG';
                break;
            case self::FATAL:
                $title = 'DEBUG';
                break;
            default :
                return false;
        }
        echo $title.':'.$msg."<br>\n";
        return true;
    }
}