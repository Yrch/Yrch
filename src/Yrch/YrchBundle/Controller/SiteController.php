<?php

namespace Yrch\YrchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * SiteController
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
class SiteController extends Controller
{
    public function showAction($id)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $siteRepo = $em->getRepository('Yrch\YrchBundle\Entity\Site');
        $site = $siteRepo->find($id);
        // TODO: uncomment it when the security will be enabled
        $outlink = /*($this->get('security.context')->isAuthenticated())? $this->get('security.context')->getUser()->getOutlink():*/"_blank";
        return $this->render('YrchBundle:Site:show.html.twig', compact('site', 'outlink'));
    }
}
