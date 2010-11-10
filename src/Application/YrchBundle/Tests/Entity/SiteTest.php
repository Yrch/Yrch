<?php

namespace Application\YrchBundle\Tests\Entity;

use Application\YrchBundle\Entity\Site;
use Application\YrchBundle\Entity\User;

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

    /**
     * @todo Implement testTitle().
     */
    public function testTitle()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testDescription().
     */
    public function testDescription()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
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

    /**
     * @todo Implement testNotes().
     */
    public function testNotes()
    {
        $site = new Site();
        $this->assertEquals('', $site->getNotes());

        $site->setNotes('This is a test');
        $this->assertEquals('This is a test', $site->getNotes());
    }
    
    public function testOwner()
    {
        $site = new Site();
        $this->assertNull($site->getOwner());

        $user = new User();
        $site->setOwner($user);
        $this->assertEquals($user, $site->getOwner());
    }

    /**
     * @todo Implement testSetTranslatableLocale().
     */
    public function testSetTranslatableLocale()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}

?>
