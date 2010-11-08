<?php

namespace Application\YrchBundle\Entity;

/**
 * @Table(name="site_translations", indexes={
 *      @index(name="site_translation_idx", columns={"locale", "entity", "foreign_key", "field"})
 * })
 * @Entity(repositoryClass="DoctrineExtensions\Translatable\Repository\TranslationRepository")
 */
class SiteTranslation
{
    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $locale
     *
     * @Column(name="locale", type="string", length=8)
     */
    private $locale;

    /**
     * @var string $entity
     *
     * @Column(name="entity", type="string", length=255)
     */
    private $entity;

    /**
     * @var string $field
     *
     * @Column(name="field", type="string", length=32)
     */
    private $field;

    /**
     * @var string $foreignKey
     *
     * @Column(name="foreign_key", type="string", length="64")
     */
    private $foreignKey;

    /**
     * @var text $content
     *
     * @Column(name="content", type="text", nullable=true)
     */
    private $content;
}
