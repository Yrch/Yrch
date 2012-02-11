<?php

$vendorDir = __DIR__.'/../vendor';

use Symfony\Component\ClassLoader\UniversalClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'                        => array($vendorDir.'/symfony/src', $vendorDir.'/bundles'),
    'Yrch'                           => __DIR__.'/../src',
    'FOS'                            => $vendorDir.'/bundles',
    'Stof'                           => $vendorDir.'/bundles',
    'BeSimple'                       => $vendorDir.'/bundles',
    'Gedmo'                          => $vendorDir.'/gedmo-doctrine-extensions/lib',
    'Doctrine\\Common\\DataFixtures' => $vendorDir.'/doctrine-data-fixtures/lib',
    'Doctrine\\Common'               => $vendorDir.'/doctrine-common/lib',
    'Doctrine\\DBAL\\Migrations'     => $vendorDir.'/doctrine-migrations/lib',
    'Doctrine\\DBAL'                 => $vendorDir.'/doctrine-dbal/lib',
    'Doctrine'                       => $vendorDir.'/doctrine/lib',
    'Zend'                           => $vendorDir.'/zend/library',
    'Monolog'                        => $vendorDir.'/monolog/src',
    'Assetic'                        => $vendorDir.'/assetic/src',
));
$loader->registerPrefixes(array(
    'Twig_Extensions_' => $vendorDir.'/twig-extensions/lib',
    'Twig_'            => $vendorDir.'/twig/lib',
));
$loader->register();

// intl
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';

    $loader->registerPrefixFallbacks(array(__DIR__.'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs'));
}

AnnotationRegistry::registerLoader(function($class) use ($loader) {
    $loader->loadClass($class);
    return class_exists($class, false);
});

require_once __DIR__.'/../vendor/swiftmailer/lib/classes/Swift.php';
Swift::registerAutoload(__DIR__.'/../vendor/swiftmailer/lib/swift_init.php');
