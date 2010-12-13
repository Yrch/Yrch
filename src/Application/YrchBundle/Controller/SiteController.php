<?php

namespace Application\YrchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SiteController extends Controller
{
    public function showAction($id)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $siteRepo = $em->getRepository('Application\YrchBundle\Entity\Site');
        $site = $siteRepo->find($id);
        // TODO: uncomment it when the security will be enabled
        $outlink = /*($this->get('security.context')->isAuthenticated())? $this->get('security.context')->getUser()->getOutlink():*/"_blank";
        return $this->render('YrchBundle:Site:show.twig', compact('site', 'outlink'));
    }
}
