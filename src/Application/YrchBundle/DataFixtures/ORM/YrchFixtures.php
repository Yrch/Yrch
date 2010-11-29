<?php

namespace Application\YrchBundle\DataFixtures\ORM;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Application\YrchBundle\Entity\Category;

class YrchFixtures implements FixtureInterface
{
    public function load($manager)
    {
        $categoryRepo = $manager->getRepository('Application\\YrchBundle\\Entity\\Category');
        $rootNodes = $categoryRepo->children(null, true);
        $rootCategory = $rootNodes[0];
        $categories = array();
        for ($i = 0; $i < 5; $i++) {
            $cat = $this->createCategory($i, $rootCategory);
            $categories[$i] = $cat;
            $manager->persist($cat);
        }
        for ($i = 5; $i < 8; $i++) {
            $cat = $this->createCategory($i, $categories[1]);
            $categories[$i] = $cat;
            $manager->persist($cat);
        }
        for ($i = 8; $i < 10; $i++) {
            $cat = $this->createCategory($i, $categories[2]);
            $categories[$i] = $cat;
            $manager->persist($cat);
        }
        $manager->flush();
        for ($index = 0; $index < count($categories); $index++) {
            $categories[$index]->setTranslatableLocale('fr');
            $categories[$index]->setName('Catégorie '.$i);
            $categories[$index]->setDescription('catégorie de test n°'.$i);
            $manager->persist($categories[$index]);
        }
        $manager->flush();
    }

    /**
     * Create a new category
     *
     * @param int $i
     * @param Category $parent
     * @return Category
     */
    protected function createCategory($i, Category $parent)
    {
        $cat = new Category();
        $cat->setTranslatableLocale('en');
        $cat->setName('Category '.$i);
        $cat->setParent($parent);
        $cat->setDescription('test category number '.$i);
        return $cat;
    }

}
