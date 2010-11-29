<?php

namespace Application\YrchBundle\DataFixtures\ORM;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Application\YrchBundle\Entity\Category;
use Application\YrchBundle\Entity\Site;
use Application\YrchBundle\Entity\User;

class YrchFixtures implements FixtureInterface
{
    public function load($manager)
    {
        $categoryRepo = $manager->getRepository('Application\\YrchBundle\\Entity\\Category');
        $rootNodes = $categoryRepo->children(null, true);
        $rootCategory = $rootNodes[0];
        $categories = array();
        $users = array();
        $sites = array();
        // Categories
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
            $categories[$index]->setName('Catégorie '.$index);
            $categories[$index]->setDescription('catégorie de test n°'.$index);
            $manager->persist($categories[$index]);
        }
        $manager->flush();
        // Users
        for ($i = 0; $i < 5; $i++) {
            $user = $this->createUser($i);
            $users[$i] = $user;
            $manager->persist($user);
        }
        // Sites
        for ($i = 0; $i < 15; $i++) {
            $site = $this->createSite($i, $users[$i % 5]);
            $site->addCategory($categories[$i % 10]);
            $site->addCategory($categories[($i+2) % 7]);
            $sites[$i] = $site;
            $manager->persist($site);
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

    /**
     * Create a new user
     *
     * @param int $i
     * @return User
     */
    protected function createUser($i)
    {
        $user = new User();
        $user->setUsername('user_'.$i);
        $user->setNick('User '.$i);
        $user->setEmail('user'.$i.'@example.org');
        $user->setPassword('passwd'.$i);
        $user->setPreferedLocale('fr');
        return $user;
    }

    /**
     * Create a new site
     *
     * @param int $i
     * @param User $superOwner
     * @return Site
     */
    protected function createSite($i, User $superOwner)
    {
        $site = new Site();
        $site->setTranslatableLocale('en');
        $site->setUrl('http://'.$i.'example.org');
        $site->setName('Site '.$i);
        $site->setDescription('test site number '.$i);
        $site->setLanguages(array('en', 'fr'));
        $site->setCountries(array('US', 'CA'));
        $site->setSuperOwner($superOwner);
        return $site;
    }
}
