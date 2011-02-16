<?php

namespace Yrch\YrchBundle\Tests\DependencyInjection;

use Yrch\YrchBundle\DependencyInjection\YrchExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Test class for YrchExtension
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
class YrchExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidConfig()
    {
        $container = new ContainerBuilder();
        $loader = new YrchExtension();
        $loader->load(array (), $container);
    }

    public function testValidConfig()
    {
        $container = new ContainerBuilder();
        $loader = new YrchExtension();
        $config = array (array (
            'special_user' => array (
                'username' => 'test',
                'nick' => 'Test',
                'email' => 'test@example.org'
            )
        ));
        $loader->load($config, $container);
        $this->assertEquals('test', $container->getParameter('yrch.special_user.username'));
        $this->assertEquals('Test', $container->getParameter('yrch.special_user.nick'));
        $this->assertEquals('test@example.org', $container->getParameter('yrch.special_user.email'));
    }
}
