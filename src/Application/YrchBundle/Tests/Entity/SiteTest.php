<?php

namespace Application\YrchBundle\Tests\Entity;

use Application\YrchBundle\Entity\Site;
use Application\YrchBundle\Entity\User;
use Application\YrchBundle\Entity\Category;
use Application\YrchBundle\Entity\Review;
use Application\YrchBundle\Entity\SiteTemp;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Test class for Site
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
class SiteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Site
     */
    private $site;

    public function  setUp()
    {
        $this->site = new Site();
    }

    public function testAverageScore()
    {
        $this->assertNull($this->site->getAverageScore());

        $this->site->setAverageScore(5);
        $this->assertEquals(5, $this->site->getAverageScore());
    }

    public function testSelection()
    {
        $this->assertFalse($this->site->isSelectioned());

        $this->site->addToSelection();
        $this->assertTrue($this->site->isSelectioned());

        $this->site->removeFromSelection();
        $this->assertFalse($this->site->isSelectioned());
    }

    public function testLeech()
    {
        $this->assertFalse($this->site->isLeech());

        $this->site->setLeech(true);
        $this->assertTrue($this->site->isLeech());

        $this->site->setLeech(false);
        $this->assertFalse($this->site->isLeech());
    }

    public function testStatus()
    {
        $this->assertEquals('pending', $this->site->getStatus());

        $this->site->setStatus('ok');
        $this->assertEquals('ok', $this->site->getStatus());
    }

    public function testNotes()
    {
        $this->assertEquals('', $this->site->getNotes());

        $this->site->setNotes('This is a test');
        $this->assertEquals('This is a test', $this->site->getNotes());
    }

    public function testReviews()
    {
        $this->assertEquals(new ArrayCollection(), $this->site->getReviews());

        $review = new Review();
        $this->site->addReview($review);
        $this->assertEquals($this->site, $review->getSite());
        $this->assertContains($review, $this->site->getReviews());
    }

    public function testSuperOwner()
    {
        $this->assertNull($this->site->getSuperOwner());

        $user = new User();
        $this->site->setSuperOwner($user);
        $this->assertEquals($user, $this->site->getSuperOwner());
        $this->assertContains($user, $this->site->getOwners());
    }

    public function testOwners()
    {
        $this->assertEquals(new ArrayCollection(), $this->site->getOwners());

        $user = new User();
        $this->site->addOwner($user);
        $this->assertContains($user, $this->site->getOwners());

        $user2 = new User();
        $this->site->setSuperOwner($user2);
        $this->assertEquals(2, $this->site->getOwners()->count());

        $this->site->removeOwner($user);
        $this->assertNotContains($user, $this->site->getOwners());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSuperOwnerException()
    {
        $user = new User();
        $this->site->setSuperOwner($user);
        $this->site->removeOwner($user);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testOwnersException()
    {
        $user = new User();
        $this->site->addOwner($user);
        $this->site->removeOwner($user);
    }

    public function testSiteTemp()
    {
        $this->assertNull($this->site->getSiteTemp());

        $temp = new SiteTemp();
        $this->site->setSiteTemp($temp);
        $this->assertEquals($temp, $this->site->getSiteTemp());
    }

    public function testSetTranslatableLocale()
    {
        $this->site->setTranslatableLocale('de');
        $this->assertAttributeEquals('de', 'locale', $this->site);
    }

}
