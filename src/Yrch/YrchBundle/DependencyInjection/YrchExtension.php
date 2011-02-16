<?php

namespace Yrch\YrchBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * YrchExtension
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
class YrchExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('translation.xml');
        $loader->load('twig.xml');
        $loader->load('logger.xml');
        $loader->load('collectors.xml');
        $loader->load('orm.xml');

        foreach ($configs as $config) {
            if (isset($config['special_user'])) {
                if (isset($config['special_user']['username'])) {
                    $container->setParameter('yrch.special_user.username', $config['special_user']['username']);
                }
                if (isset($config['special_user']['nick'])) {
                    $container->setParameter('yrch.special_user.nick', $config['special_user']['nick']);
                }
                if (isset($config['special_user']['email'])) {
                    $container->setParameter('yrch.special_user.email', $config['special_user']['email']);
                }
            }
        }

        if (!$container->hasParameter('yrch.special_user.username') || !$container->hasParameter('yrch.special_user.nick') || !$container->hasParameter('yrch.special_user.email')) {
            throw new \InvalidArgumentException('You must provide the yrch.special_user configuration');
        }
    }

    public function getAlias()
    {
        return 'yrch';
    }
}
