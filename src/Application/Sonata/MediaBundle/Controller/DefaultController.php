<?php

namespace Application\Sonata\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ApplicationSonataMediaBundle:Default:index.html.twig', array('name' => $name));
    }
}
