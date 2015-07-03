<?php

require_once($_SERVER['DOCUMENT_ROOT'] .'/../config/path.php');
require_once(URL . '/Core/Loader.php');

$loader = new Loader();

try {

    $app = new Core\Application();
    $app->run();

}catch (InvalidArgumentException $e){
    include URL . "src/error.php";exit;
}catch (Exception $e){
    Core\Service::get('log')->error($e->getMessage() . " & Code " . $e->getCode().$e->getFile().$e->getLine());
    include URL ."src/error.php";exit;
}
