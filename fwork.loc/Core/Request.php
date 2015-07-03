<?php

namespace Core;

class Request{

    public function getUrl(){

        return $_SERVER['REQUEST_URI'];
    }

//    public function getVars(){
//
//        $vars = array();
//
//        $uri_parsed = parse_url($this->getUrl());
//
//        if(!empty($uri_parsed['query'])){
//            parse_str($uri_parsed['query'], $vars);
//        }
//
//        return $vars;
//    }
}