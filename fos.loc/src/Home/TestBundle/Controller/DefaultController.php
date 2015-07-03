<?php

namespace Home\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HomeTestBundle:Default:index.html.twig', array('name' => $name));
    }
}
