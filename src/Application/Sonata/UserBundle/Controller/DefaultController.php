<?php

namespace Application\Application\Sonata\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ApplicationSonataUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
