<?php

namespace Core;

interface UserInterface{

    public function authorize($login, $password, $remember);
    public function getRole();
}