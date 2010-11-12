<?php

namespace Application\YrchBundle\Entity;

use Bundle\DoctrineExtensionsBundle\Entity\AbstractTranslation;

/**
 * @orm:Table(name="review_translations", indexes={
 *      @orm:index(name="review_translation_idx", columns={"locale", "entity", "foreign_key", "field"})
 * })
 * @orm:Entity(repositoryClass="DoctrineExtensions\Translatable\Repository\TranslationRepository")
 */
class ReviewTranslation extends AbstractTranslation
{
}
