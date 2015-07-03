<?php
namespace Core;

class RedirectResponse extends Response
{

    public $code;
    public $url;
    public $replace;

    public function __construct($url, $replace = true, $code = 302)
    {
        if (empty($url)) {
            throw new \InvalidArgumentException('Cannot redirect to an empty URL.');
        }

        $this->url = $url;
        $this->code = $code;
        $this->replace = $replace;

    }

    public function send(){

        header('Location: ' .$this->url, $this->replace, $this->code);

        exit();
    }

}