<?php

namespace Application\YrchBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class YrchExtension extends Extension
{
    public function configLoad(array $config, ContainerBuilder $container)
    {
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
        return __DIR__.'/../Resources/config/schema';
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
