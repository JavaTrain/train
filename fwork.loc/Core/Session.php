<?php

namespace Core;

class Session{

    public function __construct(){
        session_name("fworksess");
        session_start();
    }

    public static function set($name, $value){
        $_SESSION[$name] = $value;
    }

    public static function get($name){
        return empty($_SESSION[$name]) ? null : $_SESSION[$name];
    }

    public static function delete($name){
        if(isset($_SESSION[$name])){
            unset($_SESSION[$name]);
        }
    }

}