<?php

namespace Home\TestBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HomeTestBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
