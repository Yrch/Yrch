<?php

namespace Application\YrchBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use DoctrineExtensions\Translatable\TranslationListener;

class YrchBundle extends Bundle
{
    public function boot()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $eventManager = $em->getEventManager();
        $translatableListener = new TranslationListener();
        //$translatableListener->setTranslatableLocale($this->container->get('session.default_locale'));
        $translatableListener->setTranslatableLocale('fr');
        $eventManager->addEventSubscriber($translatableListener);
    }

}
