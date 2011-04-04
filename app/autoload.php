<?php

$vendorDir = __DIR__.'/../vendor';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'                        => $vendorDir.'/symfony/src',
    'Yrch'                           => __DIR__.'/../src',
    'FOS'                            => $vendorDir.'/bundles',
    'Stof'                           => $vendorDir.'/bundles',
    'BeSimple'                       => $vendorDir.'/bundles',
    'Gedmo'                          => $vendorDir.'/gedmo-doctrine-extensions/lib',
    'Doctrine\\Common\\DataFixtures' => $vendorDir.'/doctrine-data-fixtures/lib',
    'Doctrine\\Common'               => $vendorDir.'/doctrine-common/lib',
    'Doctrine\\DBAL\\Migrations'     => $vendorDir.'/doctrine-migrations/lib',
    'Doctrine\\ODM\\MongoDB'         => $vendorDir.'/doctrine-mongodb/lib',
    'Doctrine\\DBAL'                 => $vendorDir.'/doctrine-dbal/lib',
    'Doctrine'                       => $vendorDir.'/doctrine/lib',
    'Zend'                           => $vendorDir.'/zend/library',
    'Monolog'                        => $vendorDir.'/monolog/src',
    'Assetic'                        => $vendorDir.'/assetic/src',
));
$loader->registerPrefixes(array(
    'Swift_'           => $vendorDir.'/swiftmailer/lib/classes',
    'Twig_Extensions_' => $vendorDir.'/twig-extensions/lib',
    'Twig_'            => $vendorDir.'/twig/lib',
));
$loader->register();
