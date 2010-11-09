<?php

namespace Application\YrchBundle\Entity;

/**
 * @orm:Table(name="site_translations", indexes={
 *      @orm:index(name="site_translation_idx", columns={"locale", "entity", "foreign_key", "field"})
 * })
 * @orm:Entity(repositoryClass="DoctrineExtensions\Translatable\Repository\TranslationRepository")
 */
class SiteTranslation
{
    /**
     * @var integer $id
     *
     * @orm:Column(name="id", type="integer")
     * @orm:Id
     * @orm:GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $locale
     *
     * @orm:Column(name="locale", type="string", length=8)
     */
    private $locale;

    /**
     * @var string $entity
     *
     * @orm:Column(name="entity", type="string", length=255)
     */
    private $entity;

    /**
     * @var string $field
     *
     * @orm:Column(name="field", type="string", length=32)
     */
    private $field;

    /**
     * @var string $foreignKey
     *
     * @orm:Column(name="foreign_key", type="string", length="64")
     */
    private $foreignKey;

    /**
     * @var text $content
     *
     * @orm:Column(name="content", type="text", nullable=true)
     */
    private $content;
}
