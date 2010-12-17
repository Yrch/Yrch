<?php

namespace Application\YrchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * MainController
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
class MainController extends Controller
{
    public function indexAction()
    {
        try {
            $locale = $this->get('request')->getPreferredLanguage($this->container->getParameter('yrch.languages'));
        } catch (\Exception $e) {
            $locale = $this->container->getParameter('session.default_locale');
        }
        return $this->redirect($this->generateUrl($this->get('templating.helper.locale')->getRoute("localized_homepage", $locale)));
    }
}
