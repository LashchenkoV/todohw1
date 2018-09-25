<?php
/**
 * Created by PhpStorm.
 * Note: mamedov
 * Date: 13.09.2018
 * Time: 19:30
 */

namespace core\system;


class Request
{
    private static $body_params=null;

    public static function get($name){
        return @$_GET[$name];
    }
    public static function post($name){
        return @$_POST[$name];
    }
    public static function put($name){
        return self::getBodyParams($name);
    }
    public static function delete($name){
        return self::getBodyParams($name);
    }

    public static function isMethodType(string $type){
        return strtolower($_SERVER["REQUEST_METHOD"])===strtolower($type);
    }

    public static function getBodyParams($name){
        if(self::$body_params!=null) return @self::$body_params[$name];
        $putdata = file_get_contents('php://input');
        $exploded = explode('&', $putdata);
        self::$body_params=[];
        foreach($exploded as $pair) {
            $item = explode('=', $pair);
            if(count($item) == 2)
                self::$body_params[urldecode($item[0])] = urldecode($item[1]);
        }
        return @self::$body_params[$name];
    }


    public static function isGet(){
        return self::isMethodType("GET");
    }
    public static function isPost(){
        return self::isMethodType("POST");
    }
    public static function isPut(){
        return self::isMethodType("PUT");
    }
    public static function isDelete(){
        return self::isMethodType("DELETE");
    }
}