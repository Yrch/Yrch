<?php

namespace Application\YrchBundle\Entity;

use Bundle\DoctrineExtensionsBundle\Entity\AbstractTranslation;

/**
 * ReviewTranslation
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 *
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
