<?php

namespace Core;

class Service{

    private static $registry = array();

    public static function set($service_name, $service){
        self::$registry[$service_name] = $service;
    }

    public static function get($service_name){
        return empty(self::$registry[$service_name]) ? null : self::$registry[$service_name];
    }
}