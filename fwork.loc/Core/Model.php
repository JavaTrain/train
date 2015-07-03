<?php
namespace Core;

use Core\Service;
/**
 * Created by PhpStorm.
 * User: lamp
 * Date: 12.06.15
 * Time: 11:28
 */
abstract Class Model{

    protected $db;

    public function __construct(){
        $this->db = Service::get('pdo');
    }
}