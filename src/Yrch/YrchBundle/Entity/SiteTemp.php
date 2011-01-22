<?php

namespace Yrch\YrchBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Yrch\YrchBundle\Entity\AbstractSite
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 *
 * @orm:Table(name="site_temp")
 * @orm:Entity(repositoryClass="Yrch\YrchBundle\Repository\SiteRepository")
 */
class SiteTemp extends AbstractSite
{
}
