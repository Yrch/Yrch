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
    /**
     * @var Review
     */
    private $review;

    public function  setUp()
    {
        $this->review = new Review();
    }

    public function testScore()
    {
        $this->assertNull($this->review->getScore());

        $this->review->setScore(5);
        $this->assertEquals(5, $this->review->getScore());

        $this->review->setScore(null);
        $this->assertNull($this->review->getScore());
    }

    public function testText()
    {
        $this->assertNull($this->review->getText());

        $this->review->setText('test title');
        $this->assertEquals('test title', $this->review->getText());
    }

    public function testStatus()
    {
        $this->assertEquals('pending', $this->review->getStatus());

        $this->review->setStatus('ok');
        $this->assertEquals('ok', $this->review->getStatus());
    }

    public function testOwner()
    {
        $this->assertNull($this->review->getOwner());

        $user = new User();
        $this->review->setOwner($user);
        $this->assertEquals($user, $this->review->getOwner());
    }

    public function testSite()
    {
        $this->assertNull($this->review->getSite());

        $site = new Site();
        $this->review->setSite($site);
        $this->assertEquals($site, $this->review->getSite());
    }

    public function testSetTranslatableLocale()
    {
        $this->review->setTranslatableLocale('de');
        $this->assertAttributeEquals('de', 'locale', $this->review);
    }

    public function testCreatedAt()
    {
        $this->assertNull($this->review->getCreatedAt());

        $now = new \DateTime("now");
        $this->review->setCreatedAt($now);
        $this->assertEquals($now, $this->review->getCreatedAt());
    }

    public function testUpdatedAt()
    {
        $this->assertNull($this->review->getUpdatedAt());

        $now = new \DateTime("now");
        $this->review->setUpdatedAt($now);
        $this->assertEquals($now, $this->review->getUpdatedAt());
    }

}
