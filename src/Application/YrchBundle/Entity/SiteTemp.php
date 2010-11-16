<?php

namespace Application\YrchBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Application\YrchBundle\Entity\AbstractSite
 *
 * @orm:Table(name="site_temp")
 * @orm:Entity(repositoryClass="Application\YrchBundle\Repository\SiteRepository")
 */
class SiteTemp extends AbstractSite
{
}
