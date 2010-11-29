<?php

namespace Application\YrchBundle\Entity;

use Bundle\DoctrineExtensionsBundle\Entity\AbstractTranslation;

/**
 * @orm:Table(
 *          name="review_translations",
 *          indexes={@orm:index(name="review_translations_lookup_idx", columns={
 *             "locale", "entity", "foreign_key"
 *         })},
 *         uniqueConstraints={@orm:UniqueConstraint(name="review_lookup_unique_idx", columns={
 *             "locale", "entity", "foreign_key", "field"
 *         })}
 * )
 * @orm:Entity(repositoryClass="Gedmo\Translatable\Repository\TranslationRepository")
 */
class ReviewTranslation extends AbstractTranslation
{
}
