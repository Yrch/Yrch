<?php

namespace Yrch\YrchBundle\DataFixtures\ORM;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Yrch\YrchBundle\Entity\Category;
use Yrch\YrchBundle\Entity\Site;
use Yrch\YrchBundle\Entity\User;
use Yrch\YrchBundle\Entity\Review;

/**
 * YrchFixtures
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
class YrchFixtures implements FixtureInterface
{
    public function load($manager)
    {
        $categoryRepo = $manager->getRepository('Yrch\\YrchBundle\\Entity\\Category');
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
            $site->setStatus('ok');
            $sites[$i] = $site;
            $manager->persist($site);
        }
        // Reviews
        for ($i = 0; $i < 50; $i++) {
            $review = $this->createReview($i, $users[$i % 5], $sites[($i+3) % 15]);
            $manager->persist($review);
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
        $user->setUsernameCanonical(mb_convert_case($user->getUsername(), MB_CASE_LOWER, mb_detect_encoding($user->getUsername())));
        $user->setNick('User '.$i);
        $user->setEmail('user'.$i.'@example.org');
        $user->setEmailCanonical(mb_convert_case($user->getEmail(), MB_CASE_LOWER, mb_detect_encoding($user->getEmail())));
        $user->setPassword('passwd'.$i);
        $user->setPreferedLocale('fr');
        $user->setAlgorithm('sha1');
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
        if(!($i % 4)){
            $site->addToSelection();
        }
        $site->setSuperOwner($superOwner);
        return $site;
    }

    /**
     * Create a new review
     *
     * @param int $i
     * @param User $owner
     * @param Site $site
     * @return Review
     */
    protected function createReview($i, User $owner, Site $site)
    {
        $review = new Review();
        $review->setOwner($owner);
        $review->setSite($site);
        $review->setStatus('ok');
        $review->setTranslatableLocale('fr');
        $review->setText('test review number '.$i);
        $review->setScore(rand(1, 10));
        return $review;
    }
}
