<?php
namespace pwframe\lib\utils;

class ApiUtil {

    public static $autoDisplay = true;
    
    public static function echoResult($code, $message = null, $data = null) {
        if(null === $message) {
            switch ($code) {
                case 0 :
                    $message = '操作成功';
                    break;
                case 403 :
                    $message = '禁止访问';
                    break;
                case 404 :
                    $message = '信息不存在';
                    break;
                case 500 :
                    $message = '操作失败';
                    break;
            }
        }
        $json = @json_encode(array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        ));
        return self::echoCallback($json);
    }

    public static function echoCallback($json) {
        if(isset($_REQUEST['callback'])) {
            $callback = htmlspecialchars($_REQUEST['callback']);
            if(!empty($callback)) $json = $callback.'('.$json.')';
        }
        if(self::$autoDisplay) {
            echo $json;
            return null;
        } else {
            return $json;
        }
    }

}