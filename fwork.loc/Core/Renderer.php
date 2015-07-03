<?php
namespace Core;

class Renderer{

    protected $data = array();
    protected $layout;

    public function __construct($layout){
        $this->layout = $layout;
    }

    public function setVars($vars = array()){

        $this->data = array_merge($this->data, $vars);
    }

    public function render(){

        extract($this->data);

        ob_start();
        include($this->layout);
        $content = ob_get_clean();

        return $content;
    }
}