<?php

namespace Application\DataDog\AuditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ApplicationApplicationDataDogAuditBundle:Default:index.html.twig');
    }
}
