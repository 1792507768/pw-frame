<?php
namespace pwframe\lib\frame;

class Session {
    
    private static $instance;
    private $sessionArray; // SESSION内容
    
    private function __construct() {}
    
    public static function getInstance() {
        if(null == self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * 获取Session值，仅当调用时再打开Session
     * @param string $key 为null时返回全部
     */
    public function get($key = null) {
        if(null === $_SESSION) {
            session_start();
            $this->sessionArray = $_SESSION;
            session_write_close();
        }
        if(null === $key) return $_SESSION;
        if(isset($_SESSION[$key])) return $_SESSION[$key];
        return null;
    }
    
    /**
     * 设置Session值，不会立即持久化
     * 若需要立即持久化，可手动调用save方法；否则，仅在请求结束后再统一持久化
     * @param mixed $value 若为null则删除当前Key
     */
    public function set($key, $value = null) {
        if(null === $value) {
            unset($_SESSION[$key]);
        } else {
            $_SESSION[$key] = $value;
        }
    }
    
    /**
     * 立即持久化Session值
     * @param array $data 若不为null则采用传入参数替换全部Session
     */
    public function save(array $data = null) {
        if(null !== $data) {
            $_SESSION = $data;
        }
        if(null === $_SESSION || $this->sessionArray == $_SESSION) {
            return ; // 没调用过Session或Session没有更改
        }
        session_start();
        $this->sessionArray = $_SESSION;
        session_write_close();
    }
    
    public function __destruct() {
        $this->save(); // 在请求结束时统一写入Session，尽量避免长时间持有资源
    }
    
}