<?php

namespace Application\YrchBundle\Tests\Entity;

use Application\YrchBundle\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Test class for User
 */
class CategoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Category
     */
    private $category;

    public function  setUp()
    {
        $this->category = new Category();
    }

    public function testName()
    {
        $this->assertNull($this->category->getName());

        $this->category->setName('test');
        $this->assertEquals('test', $this->category->getName());
    }

    public function testDescription()
    {
        $this->assertNull($this->category->getDescription());

        $this->category->setDescription('test description');
        $this->assertEquals('test description', $this->category->getDescription());
    }

    public function testSites()
    {
        $this->assertNull($this->category->getParent());

        $parent = new Category();
        $this->category->setParent($parent);
        $this->assertEquals($parent, $this->category->getParent());
    }

    public function testSetTranslatableLocale()
    {
        $this->category->setTranslatableLocale('de');
        $this->assertAttributeEquals('de', 'locale', $this->category);
    }
}
