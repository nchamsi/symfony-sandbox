<?php

namespace Application\Sonata\NotificationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ApplicationSonataNotificationBundle:Default:index.html.twig', array('name' => $name));
    }
}
