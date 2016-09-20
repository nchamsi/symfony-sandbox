<?php

namespace Application\Sonata\ClassificationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ApplicationSonataClassificationBundle:Default:index.html.twig', array('name' => $name));
    }
}
