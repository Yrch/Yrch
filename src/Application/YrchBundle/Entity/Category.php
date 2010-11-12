<?php

namespace Application\YrchBundle\Entity;

use DoctrineExtensions\Tree\Configuration;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @orm:Entity(repositoryClass="DoctrineExtensions\Tree\Repository\TreeNodeRepository")
 * @orm:Table(name="category")
 */
class Category
{
    /**
     * @var integer
     *
     * @orm:Column(name="id", type="integer")
     * @orm:Id
     * @orm:GeneratedValue
     */
    protected $id;

    /**
     * @var string
     *
     * @validation:NotBlank(message='Please enter the title')
     * @orm:Column(name="title", type="string", length=255)
     * @Translatable
     */
    protected $title;

    /**
     * @var string
     *
     * @Locale
     */
    protected $locale;

    /**
     * @var integer
     *
     * @orm:Column(name="lft", type="integer")
     * @Tree:Left
     */
    protected $lft;

    /**
     * @var integer
     *
     * @orm:Column(name="rgt", type="integer")
     * @Tree:Right
     */
    protected $rgt;

    /**
     * @var Category
     *
     * @orm:ManyToOne(targetEntity="Application\YrchBundle\Entity\Category", inversedBy="children")
     * @Tree:Ancestor
     */
    protected $parent;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @orm:OneToMany(targetEntity="Application\YrchBundle\Entity\Category", mappedBy="parent")
     * @orm:OrderBy({"lft" = "ASC"})
     */
    protected $children;

    /**
     * @return integer
     * @codeCoverageIgnore
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get the title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set parent
     *
     * @return Category $parent
     */
    public function setParent(Category $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return Category $parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param string $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
}
