<?php

namespace Application\YrchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('YrchBundle:Main:index.twig');
    }
}
