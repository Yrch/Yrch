<?php

namespace Yrch\YrchBundle\Entity;

use Stof\DoctrineExtensionsBundle\Entity\AbstractTranslation;
use Doctrine\ORM\Mapping as ORM;

/**
 * SiteTranslation
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 *
 * @ORM\Table(
 *          name="site_translations",
 *          indexes={@ORM\index(name="site_translations_lookup_idx", columns={
 *             "locale", "object_class", "foreign_key"
 *         })},
 *         uniqueConstraints={@ORM\UniqueConstraint(name="site_lookup_unique_idx", columns={
 *             "locale", "object_class", "foreign_key", "field"
 *         })}
 * )
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 */
class SiteTranslation extends AbstractTranslation
{
}
