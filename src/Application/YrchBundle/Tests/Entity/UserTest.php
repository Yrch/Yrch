<?php

namespace Application\YrchBundle\Tests\Entity;

use Application\YrchBundle\Entity\User;
use Application\YrchBundle\Entity\Site;
use Application\YrchBundle\Entity\Review;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Test class for User
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testNick()
    {
        $user = new User();
        $this->assertNull($user->getNick());

        $user->setNick('test');
        $this->assertEquals('test', $user->getNick());
    }

    public function testLock()
    {
        $user = new User();
        $this->assertTrue($user->isAccountNonLocked());

        $user->lock();
        $this->assertFalse($user->isAccountNonLocked());

        $user->unlock();
        $this->assertTrue($user->isAccountNonLocked());
    }

    public function testPreferedLocale()
    {
        $user = new User();
        $this->assertNull($user->getPreferedLocale());

        $user->setPreferedLocale('en');
        $this->assertEquals('en', $user->getPreferedLocale());
    }

    public function testTheme()
    {
        $user = new User();
        $this->assertEquals('default', $user->getTheme());

        $user->setTheme('yrch');
        $this->assertEquals('yrch', $user->getTheme());
    }

    public function testOutlink()
    {
        $user = new User();
        $this->assertEquals('_blank', $user->getOutlink());

        $user->setOutlink('yrch_outlink');
        $this->assertEquals('yrch_outlink', $user->getOutlink());
    }

    public function testContactAllowed()
    {
        $user = new User();
        $this->assertTrue($user->isContactAllowed());

        $user->setContactAllowed(false);
        $this->assertFalse($user->isContactAllowed());
    }

    public function testSitesPerPage()
    {
        $user = new User();
        $this->assertEquals(10, $user->getSitesPerPage());

        $user->setSitesPerPage(25);
        $this->assertEquals(25, $user->getSitesPerPage());
    }

    public function testReviewsPerPage()
    {
        $user = new User();
        $this->assertEquals(25, $user->getReviewsPerPage());

        $user->setReviewsPerPage(10);
        $this->assertEquals(10, $user->getReviewsPerPage());
    }

    public function testSiteNotifications()
    {
        $user = new User();
        $this->assertTrue($user->getSiteNotifications(), 'Site notifications are enabled by default');

        $user->setSiteNotifications(false);
        $this->assertFalse($user->getSiteNotifications());
    }

    public function testReviewNotifications()
    {
        $user = new User();
        $this->assertTrue($user->getReviewNotifications(), 'Review notifications are enabled by default');

        $user->setReviewNotifications(false);
        $this->assertFalse($user->getReviewNotifications());
    }

    public function testSites()
    {
        $user = new User();
        $this->assertEquals(new ArrayCollection(), $user->getSites(), 'A new user has no site');

        $site = new Site();
        $user->addSite($site);
        $this->assertContains($site, $user->getSites());
    }

    public function testFavorites()
    {
        $user = new User();
        $this->assertEquals(new ArrayCollection(), $user->getFavorites(), 'A new user has no favorite');

        $site = new Site();
        $user->addFavorite($site);
        $this->assertContains($site, $user->getFavorites());

        $this->assertTrue($user->isFavorite($site));
    }

    public function testReviews()
    {
        $user = new User();
        $this->assertEquals(new ArrayCollection(), $user->getReviews(), 'A new user has no review');

        $review = new Review();
        $user->addReview($review);
        $this->assertEquals($user, $review->getOwner());
        $this->assertContains($review, $user->getReviews());
    }
}
