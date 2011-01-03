<?php

namespace Application\YrchBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * YrchExtension
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
class YrchExtension extends Extension
{
    public function configLoad(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, __DIR__.'/../Resources/config');
        $loader->load('translation.xml');
        $loader->load('route.xml');
        $loader->load('logger.xml');

        if (isset($config['special_user'])) {
            $container->setParameter('yrch.special_user.username', $config['special_user']['username']);
            $container->setParameter('yrch.special_user.nick', $config['special_user']['nick']);
            $container->setParameter('yrch.special_user.email', $config['special_user']['email']);
        } else {
            throw new \InvalidArgumentException('You must provide the yrch.special_user configuration');
        }
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     */
    public function getXsdValidationBasePath()
    {
        return null;
    }

    public function getNamespace()
    {
        return 'http://www.symfony-project.org/schema/dic/yrch';
    }

    public function getAlias()
    {
        return 'yrch';
    }
}
