<?php

namespace Application\YrchBundle\Tests\Entity;

use Application\YrchBundle\Entity\AbstractSite;
use Application\YrchBundle\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;

class FakeSite extends AbstractSite
{
}

/**
 * Test class for AbstractSite
 */
class AbstractSiteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FakeSite
     */
    private $site;

    public function  setUp()
    {
        $this->site = new FakeSite();
    }

    public function testUrl()
    {
        $this->assertNull($this->site->getUrl());

        $this->site->setUrl('http://example.org');
        $this->assertEquals('http://example.org', $this->site->getUrl());
    }

    public function testName()
    {
        $this->assertNull($this->site->getName());

        $this->site->setName('test name');
        $this->assertEquals('test name', $this->site->getName());
    }

    public function testDescription()
    {
        $this->assertNull($this->site->getDescription());

        $this->site->setDescription('test description');
        $this->assertEquals('test description', $this->site->getDescription());
    }

    public function testCategories()
    {
        $this->assertEquals(new ArrayCollection(), $this->site->getCategories());

        $category = new Category();
        $this->site->addCategory($category);
        $this->assertContains($category, $this->site->getCategories());

        $this->site->removeCategory($category);
        $this->assertNotContains($category, $this->site->getCategories());
    }

    public function testSetTranslatableLocale()
    {
        $this->site->setTranslatableLocale('de');
        $this->assertAttributeEquals('de', 'locale', $this->site);
    }

    public function testCreatedAt()
    {
        $this->assertNull($this->site->getCreatedAt());

        $now = new \DateTime("now");
        $this->site->setCreatedAt($now);
        $this->assertEquals($now, $this->site->getCreatedAt());
    }

    public function testUpdatedAt()
    {
        $this->assertNull($this->site->getUpdatedAt());

        $now = new \DateTime("now");
        $this->site->setUpdatedAt($now);
        $this->assertEquals($now, $this->site->getUpdatedAt());
    }

    public function testLanguages()
    {
        $this->assertEquals(array (), $this->site->getLanguages());

        $this->site->setLanguages(array ('fr', 'en'));
        $this->assertEquals(array ('fr', 'en'), $this->site->getLanguages());

        $this->site->populateStrings();
        $this->assertAttributeEquals('fr|en', 'stored_languages', $this->site);

        $this->site->setLanguages(array ());
        $this->assertEmpty($this->site->getLanguages());

        $this->site->populateArrays();
        $this->assertEquals(array ('fr', 'en'), $this->site->getLanguages());
    }

    public function testCountries()
    {
        $this->assertEquals(array (), $this->site->getCountries());

        $this->site->setCountries(array ('FR', 'US'));
        $this->assertEquals(array ('FR', 'US'), $this->site->getCountries());

        $this->site->populateStrings();
        $this->assertAttributeEquals('FR|US', 'stored_countries', $this->site);

        $this->site->setCountries(array ());
        $this->assertEmpty($this->site->getCountries());
        
        $this->site->populateArrays();
        $this->assertEquals(array ('FR', 'US'), $this->site->getCountries());
    }
}
