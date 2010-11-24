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
            $categories = $categoryRepo->children(null, true);
        } else {
            $category = $categoryRepo->find($id_category);
            $categories = $categoryRepo->children($category, true);
        }
        return $this->render('YrchBundle:Category:menu.twig', array ('categories' => $categories));
    }
}
