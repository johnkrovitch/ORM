<?php

namespace JohnKrovitch\ORMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JohnKrovitchORMBundle:Default:index.html.twig', array('name' => $name));
    }
}
