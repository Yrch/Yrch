<?php

namespace Application\YrchBundle\Tests\DependencyInjection;

use Application\YrchBundle\DependencyInjection\YrchExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Test class for YrchExtension
 */
class YrchExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testconfigLoad()
    {
        $container = new ContainerBuilder();
        $loader = new YrchExtension();
        try {
            $loader->configLoad(array (), $container);
        } catch (\Exception $e){
            $this->assertInstanceOf('\InvalidArgumentException', $e, 'The special_user configuration is mandatory');
        }

        $container = new ContainerBuilder();
        $loader = new YrchExtension();
        $config = array (
            'special_user' => array (
                'username' => 'test',
                'nick' => 'Test',
                'email' => 'test@example.org'
            )
        );
        $loader->configLoad($config, $container);
        $this->assertEquals('test', $container->getParameter('yrch.special_user.username'));
        $this->assertEquals('Test', $container->getParameter('yrch.special_user.nick'));
        $this->assertEquals('test@example.org', $container->getParameter('yrch.special_user.email'));
    }
}
