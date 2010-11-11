<?php

namespace Application\YrchBundle\Tests\Entity;

use Application\YrchBundle\Entity\Site;
use Application\YrchBundle\Entity\User;
use Application\YrchBundle\Entity\Review;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Test class for Review
 */
class ReviewTest extends \PHPUnit_Framework_TestCase
{
    public function testScore()
    {
        $review = new Review();
        $this->assertNull($review->getScore());

        $review->setScore(5);
        $this->assertEquals(5, $review->getScore());

        $review->setScore(null);
        $this->assertNull($review->getScore());
    }

    public function testText()
    {
        $review = new Review();
        $this->assertNull($review->getText());

        $review->setText('test title');
        $this->assertEquals('test title', $review->getText());
    }

    public function testStatus()
    {
        $review = new Review();
        $this->assertEquals('pending', $review->getStatus());

        $review->setStatus('ok');
        $this->assertEquals('ok', $review->getStatus());
    }

    public function testOwner()
    {
        $review = new Review();
        $this->assertNull($review->getOwner());

        $user = new User();
        $review->setOwner($user);
        $this->assertEquals($user, $review->getOwner());
    }

    public function testSite()
    {
        $review = new Review();
        $this->assertNull($review->getSite());

        $site = new Site();
        $review->setSite($site);
        $this->assertEquals($site, $review->getSite());
    }

    public function testSetTranslatableLocale()
    {
        $review = new Review();
        $review->setTranslatableLocale('de');
        $this->assertAttributeEquals('de', 'locale', $review);
    }

}
