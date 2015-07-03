<?php

namespace Core;

class Cookie{


    public static function put($name, $value, $expiry){
        if(setcookie($name,$value, time() + $expiry, '/')){
            return true;
        }
        return false;
    }

    public static function delete($name){
        if(isset($_COOKIE[$name])){
            setcookie($name,'', time()-1);
        }
        return false;
    }

    public static function get($name){
        return empty($_COOKIE[$name]) ? null : $_COOKIE[$name];
    }
}