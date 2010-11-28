<?php

namespace Application\YrchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    public function menuAction($id_category = null)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $categoryRepo = $em->getRepository('Application\YrchBundle\Entity\Category');
        if (null === $id_category){
            $rootnodes = $categoryRepo->children(null, true);
            $category = $rootnodes[0];
        } else {
            $category = $categoryRepo->find($id_category);
        }
        $categories = $categoryRepo->children($category, true);
        $path = $categoryRepo->getPath($category);
        return $this->render('YrchBundle:Category:menu.twig', array ('categories' => $categories));
    }

    public function showAction($id = null)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $categoryRepo = $em->getRepository('Application\YrchBundle\Entity\Category');
        $siteRepo = $em->getRepository('Application\YrchBundle\Entity\Site');
        if (null === $id){
            $rootnodes = $categoryRepo->children(null, true);
            $category = $rootnodes[0];
            $path = array ($category);
        } else {
            $category = $categoryRepo->find($id);
            $path = $categoryRepo->getPath($category);
        }
        $sites = $siteRepo->findByCategory($category);
        $id_root = $path[0]->getId();
        return $this->render('YrchBundle:Category:show.twig', compact('category', 'sites', 'path', 'id_root'));
    }
}
