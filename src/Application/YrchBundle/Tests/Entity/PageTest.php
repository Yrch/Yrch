<?php

namespace Application\YrchBundle\Tests\Entity;

use Application\YrchBundle\Entity\Page;
use Application\YrchBundle\Entity\User;

/**
 * Test class for Page
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
class PageTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Page
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new Page();
    }

    public function testName()
    {
        $this->assertNull($this->object->getName());

        $this->object->setName('test page');
        $this->assertEquals('test page', $this->object->getName());
    }

    public function testCreatedAt()
    {
        $this->assertNull($this->object->getCreatedAt());

        $now = new \DateTime("now");
        $this->object->setCreatedAt($now);
        $this->assertEquals($now, $this->object->getCreatedAt());
    }

    public function testUpdatedAt()
    {
        $this->assertNull($this->object->getUpdatedAt());

        $now = new \DateTime("now");
        $this->object->setUpdatedAt($now);
        $this->assertEquals($now, $this->object->getUpdatedAt());
    }

    public function testLastmodifier()
    {
        $this->assertNull($this->object->getLastmodifier());

        $user = new User();
        $this->object->setLastmodifier($user);
        $this->assertEquals($user, $this->object->getLastmodifier());
    }

    public function testSetTranslatableLocale()
    {
        $this->object->setTranslatableLocale('de');
        $this->assertAttributeEquals('de', 'locale', $this->object);
    }
}
