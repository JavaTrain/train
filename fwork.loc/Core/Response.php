<?php

namespace Core;

class Response{

    public $code;
    public $type;
    public $msg;
    public $content;

    public function __construct($content, $code = 200, $msg = 'OK', $type = 'html'){

        $this->code = $code;
        $this->msg = $msg;
        $this->content = $content;
        $this->type = $type;

        return $this;
    }

    public function send(){

        header($_SERVER['HTTP_PROTOCOL'].' '.$this->code.' '.$this->msg);

        echo $this->content;
    }
}