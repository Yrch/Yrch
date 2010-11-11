<?php

namespace Application\YrchBundle\Tests\Entity;

use Application\YrchBundle\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Test class for User
 */
class CategoryTest extends \PHPUnit_Framework_TestCase
{
    public function testTitle()
    {
        $category = new Category();
        $this->assertNull($category->getTitle());

        $category->setTitle('test');
        $this->assertEquals('test', $category->getTitle());
    }

    public function testSites()
    {
        $category = new Category();
        $this->assertNull($category->getParent());

        $parent = new Category();
        $category->setParent($parent);
        $this->assertEquals($parent, $category->getParent());
    }

    public function testSetTranslatableLocale()
    {
        $category = new Category();
        $category->setTranslatableLocale('de');
        $this->assertAttributeEquals('de', 'locale', $category);
    }
}
