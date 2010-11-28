<?php

namespace Application\YrchBundle\Entity;

use Bundle\DoctrineExtensionsBundle\Entity\AbstractTranslation;

/**
 * @orm:Table(
 *          name="site_translations",
 *          indexes={@orm:index(name="site_translations_lookup_idx", columns={
 *             "locale", "entity", "foreign_key"
 *         })},
 *         uniqueConstraints={@orm:UniqueConstraint(name="site_lookup_unique_idx", columns={
 *             "locale", "entity", "foreign_key", "field"
 *         })}
 * )
 * @orm:Entity(repositoryClass="Gedmo\Translatable\Repository\TranslationRepository")
 */
class SiteTranslation extends AbstractTranslation
{
}
