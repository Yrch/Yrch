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
     * @validation:NotBlank(message='Please enter the name')
     * @orm:Column(name="name", type="string", length=255)
     * @Translatable:Field
     */
    protected $name;

    /**
     * @var string
     *
     * @Translatable:Locale
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
     * Set the name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
