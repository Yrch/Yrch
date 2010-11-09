<?php

namespace Application\YrchBundle\Tests\Entity;

use Application\YrchBundle\Entity\User;

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
}

?>
