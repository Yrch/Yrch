<?php

namespace Application\YrchBundle\Doctrine\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * The ScoreListener updates the site average score when a review is inserted
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
class ScoreListener implements EventSubscriber
{
    /**
     * List of sites whose average score needs to be updated
     *
     * @var array
     */
    protected $_pendingSiteUpdates = array();

    /**
     * List of booleans whether the site is treated
     *
     * @var array
     */
    protected $_treatedSiteUpdates = array();

    /**
     * Specifies the list of events to listen
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::postPersist,
            Events::preUpdate,
            Events::postUpdate
        );
    }

    /**
     * Checks for inserted reviews to update the average score of their site
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $em = $args->getEntityManager();
        $entity = $args->getEntity();
        $uow = $em->getUnitOfWork();
        $entityClass = get_class($entity);
        if ($entityClass == 'Application\\YrchBundle\\Entity\\Review' && $entity->getStatus() == 'ok') {
            $oid = spl_object_hash($entity->getSite());
            if (!array_key_exists($oid, $this->_pendingSiteUpdates)) {
                $this->_pendingSiteUpdates[$oid] = $entity->getSite();
            }
            $this->_treatedSiteUpdates[$oid] = false;
        }

        $this->handleUpdates($args);
    }

    /**
     * Checks for inserted reviews to update the average score of their site
     *
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->handleUpdates($args);
    }

    /**
     * Checks for updated reviews to update the average score of their site
     *
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $em = $args->getEntityManager();
        $entity = $args->getEntity();
        $uow = $em->getUnitOfWork();
        $entityClass = get_class($entity);
        if ($entityClass == 'Application\\YrchBundle\\Entity\\Review' && $this->needsUpdate($args)) {
            $oid = spl_object_hash($entity->getSite());
            if (!array_key_exists($oid, $this->_pendingSiteUpdates)) {
                $this->_pendingSiteUpdates[$oid] = $entity->getSite();
            }
            $this->_treatedSiteUpdates[$oid] = false;
        }
    }

    /**
     * Checks whether the update of the review needs an update of the site
     *
     * @param PreUpdateEventArgs $args
     * @return boolean
     */
    protected function needsUpdate(PreUpdateEventArgs $args)
    {
        if ($args->hasChangedField('status') && $args->getNewValue('status') == 'ok'){
            return true;
        }
        if ($args->hasChangedField('score') && $args->getEntity()->getStatus() == 'ok'){
            return true;
        }
        return false;
    }

    /**
     * Handles the update of sites
     *
     * @param LifecycleEventArgs $args
     */
    protected function handleUpdates(LifecycleEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        if (!$uow->getScheduledEntityInsertions() && !$uow->getScheduledEntityUpdates()) {
            // run pending updates
            $siteRepo = $em->getRepository('Application\\YrchBundle\\Entity\\Site');
            foreach ($this->_pendingSiteUpdates as $oid => $site) {
                if (!$this->_treatedSiteUpdates[$oid]){
                    $score = $siteRepo->getUpdatedAverageScore($site);
                    $uow->scheduleExtraUpdate($site, array('averageScore' => array($site->getAverageScore(), $score)));
                    $this->_treatedSiteUpdates[$oid] = true;
                }
            }
        }
    }
}