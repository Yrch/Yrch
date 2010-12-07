<?php

namespace Application\YrchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $locale = $this->get('request')->getPreferredLanguage($this->container->getParameter('yrch.languages'));
        return $this->redirect($this->generateUrl($this->get('templating.helper.locale')->getRoute("localized_homepage", $locale)));
    }
}
