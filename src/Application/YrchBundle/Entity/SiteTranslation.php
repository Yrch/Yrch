<?php

namespace Application\YrchBundle\Entity;

use Bundle\DoctrineExtensionsBundle\Entity\AbstractTranslation;

/**
 * @orm:Table(name="site_translations", indexes={
 *      @orm:index(name="site_translation_idx", columns={"locale", "entity", "foreign_key", "field"})
 * })
 * @orm:Entity(repositoryClass="DoctrineExtensions\Translatable\Repository\TranslationRepository")
 */
class SiteTranslation extends AbstractTranslation
{
}
