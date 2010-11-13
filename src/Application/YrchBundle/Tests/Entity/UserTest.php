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

    /**
     * @todo Implement testPreferedLocale
     */
    public function testPreferedLocale()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testOutlink
     */
    public function testOutlink()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testContactAllowed
     */
    public function testContactAllowed()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSitesPerPage
     */
    public function testSitesPerPage()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testReviewsPerPage
     */
    public function testReviewsPerPage()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSiteNotifications
     */
    public function testSiteNotifications()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testReviewNotifications
     */
    public function testReviewNotifications()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testSites()
    {
        $user = new User();
        $this->assertEquals(new ArrayCollection(), $user->getSites());

        $site = new Site();
        $user->addSite($site);
        $this->assertContains($site, $user->getSites());
    }

    public function testReviews()
    {
        $user = new User();
        $this->assertEquals(new ArrayCollection(), $user->getReviews());

        $review = new Review();
        $user->addReview($review);
        $this->assertEquals($user, $review->getOwner());
        $this->assertContains($review, $user->getReviews());
    }
}
