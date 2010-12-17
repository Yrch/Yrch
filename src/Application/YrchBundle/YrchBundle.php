<?php

namespace Application\YrchBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Application\YrchBundle\Doctrine\Listener\ScoreListener;

/**
 * Yrchbundle
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
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
