<?php

namespace Application\Sonata\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ApplicationSonataPageBundle:Default:index.html.twig', array('name' => $name));
    }
}
