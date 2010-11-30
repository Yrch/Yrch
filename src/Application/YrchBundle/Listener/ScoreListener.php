<?php

namespace Application\YrchBundle\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * This listener update the site average score when a review is inserted
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
            Events::postPersist
        );
    }

    /**
     * Checks for inserted reviews to update the average score of their site
     *
     * @param LifecycleEventArgs $args
     * @return void
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $em = $args->getEntityManager();
        $entity = $args->getEntity();
        $uow = $em->getUnitOfWork();
        $entityClass = get_class($entity);
        if ($entityClass == 'Application\\YrchBundle\\Entity\\Review') {
            $oid = spl_object_hash($entity->getSite());
            if (!array_key_exists($oid, $this->_pendingSiteUpdates)) {
                $this->_pendingSiteUpdates[$oid] = $entity->getSite();
            }
            $this->_treatedSiteUpdates[$oid] = false;
        }

        if (!$uow->getScheduledEntityInsertions()) {
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