<?php

namespace Yrch\YrchBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Yrch\YrchBundle\Entity\AbstractSite
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 *
 * @ORM\Table(name="site_temp")
 * @ORM\Entity(repositoryClass="Yrch\YrchBundle\Repository\SiteRepository")
 */
class SiteTemp extends AbstractSite
{
}
