<?php

namespace Core;

abstract class Controller{

    public function index(){

    }

    public function getView($name = 'default'){

        $path = URL . '/src/' . str_replace(array('\\', 'Controller'), array('/', 'views'), substr(get_class($this), 0, -10) . '/' . $name . '.php');

        if(!file_exists($path)){
          throw new \Exception("File not found [ " . $path ." ]" );
        }

//        var_dump( $path);die;

        return $path;
    }

}