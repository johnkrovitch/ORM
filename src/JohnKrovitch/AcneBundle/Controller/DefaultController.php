<?php

namespace JohnKrovitch\AcneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($ame)
    {
        return $this->render('JohnKrovitchAcneBundle:Default:index.html.twig', array());
    }
}
