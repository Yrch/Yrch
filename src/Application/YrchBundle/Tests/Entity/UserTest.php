<?php

namespace Application\YrchBundle\Tests\Entity;

use Application\YrchBundle\Entity\User;
use Application\YrchBundle\Entity\Site;
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

    public function testSites()
    {
        $user = new User();
        $this->assertEquals(new ArrayCollection(), $user->getSites());

        $site = new Site();
        $user->addSite($site);
        $this->assertContains($site, $user->getSites());
    }
}

?>
