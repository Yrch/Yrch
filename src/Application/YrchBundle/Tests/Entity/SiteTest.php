<?php

namespace Application\YrchBundle\Tests\Entity;

use Application\YrchBundle\Entity\Site;
use Application\YrchBundle\Entity\User;
use Application\YrchBundle\Entity\Category;
use Application\YrchBundle\Entity\Review;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Test class for Site
 */
class SiteTest extends \PHPUnit_Framework_TestCase
{
    public function testUrl()
    {
        $site = new Site();
        $this->assertNull($site->getUrl());

        $site->setUrl('http://example.org');
        $this->assertEquals('http://example.org', $site->getUrl());
    }

    public function testName()
    {
        $site = new Site();
        $this->assertNull($site->getName());

        $site->setName('test name');
        $this->assertEquals('test name', $site->getName());
    }

    public function testDescription()
    {
        $site = new Site();
        $this->assertNull($site->getDescription());

        $site->setDescription('test description');
        $this->assertEquals('test description', $site->getDescription());
    }

    public function testSelection()
    {
        $site = new Site();
        $this->assertFalse($site->isSelectioned());

        $site->addToSelection();
        $this->assertTrue($site->isSelectioned());

        $site->removeFromSelection();
        $this->assertFalse($site->isSelectioned());
    }

    public function testLeech()
    {
        $site = new Site();
        $this->assertFalse($site->isLeech());

        $site->setLeech(true);
        $this->assertTrue($site->isLeech());

        $site->setLeech(false);
        $this->assertFalse($site->isLeech());
    }

    public function testStatus()
    {
        $site = new Site();
        $this->assertEquals('pending', $site->getStatus());

        $site->setStatus('ok');
        $this->assertEquals('ok', $site->getStatus());
    }

    public function testNotes()
    {
        $site = new Site();
        $this->assertEquals('', $site->getNotes());

        $site->setNotes('This is a test');
        $this->assertEquals('This is a test', $site->getNotes());
    }

    public function testOwners()
    {
        $site = new Site();
        $this->assertEquals(new ArrayCollection(), $site->getOwners());

        $user = new User();
        $site->addOwner($user);
        $this->assertContains($user, $site->getOwners());

        $user2 = new User();
        $site->addOwner($user2);
        $this->assertEquals(2, $site->getOwners()->count());

        $site->removeOwner($user);
        $this->assertNotContains($user, $site->getOwners());
    }

    public function testReviews()
    {
        $site = new Site();
        $this->assertEquals(new ArrayCollection(), $site->getReviews());

        $review = new Review();
        $site->addReview($review);
        $this->assertEquals($site, $review->getSite());
        $this->assertContains($review, $site->getReviews());
    }

    /**
     * @expectedException RuntimeException
     */
    public function testOwnersException()
    {
        $site = new Site();
        $user = new User();
        $site->addOwner($user);
        $site->removeOwner($user);
    }

    public function testCategories()
    {
        $site = new Site();
        $this->assertEquals(new ArrayCollection(), $site->getCategories());

        $category = new Category();
        $site->addCategory($category);
        $this->assertContains($category, $site->getCategories());

        $site->removeCategory($category);
        $this->assertNotContains($category, $site->getCategories());
    }

    public function testSetTranslatableLocale()
    {
        $site = new Site();
        $site->setTranslatableLocale('de');
        $this->assertAttributeEquals('de', 'locale', $site);
    }

}
