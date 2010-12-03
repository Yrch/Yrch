<?php

namespace Application\YrchBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Application\YrchBundle\Listener\ScoreListener;

class YrchBundle extends Bundle
{
    public function boot()
    {
        try {
            $em = $this->container->get('doctrine.orm.entity_manager');
        } catch (\InvalidArgumentException $e){
            throw new \InvalidArgumentException('You must provide a Doctrine ORM Entity Manager');
        }
        $em->getEventManager()->addEventSubscriber(new ScoreListener());
    }
}
