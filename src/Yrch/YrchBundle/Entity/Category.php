<?php

namespace Yrch\YrchBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 *
 * @orm:Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @orm:Table(name="category")
 * @gedmo:Tree(type="nested")
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
     * @validation:NotBlank(message="Please enter the name")
     * @orm:Column(name="name", type="string", length=255)
     * @gedmo:Translatable
     */
    protected $name;

    /**
     * @var string
     *
     * @gedmo:Locale
     */
    protected $locale;

    /**
     * @var string $description
     *
     * @orm:Column(name="description", type="text")
     * @gedmo:Translatable
     */
    protected $description;

    /**
     * @var integer
     *
     * @orm:Column(name="lft", type="integer")
     * @gedmo:TreeLeft
     */
    protected $lft;

    /**
     * @var integer
     *
     * @orm:Column(name="rgt", type="integer")
     * @gedmo:TreeRight
     */
    protected $rgt;

    /**
     * @var Category
     *
     * @orm:ManyToOne(targetEntity="Yrch\YrchBundle\Entity\Category", inversedBy="children")
     * @orm:JoinColumn(name="parent_id", referencedColumnName="id", onDelete="cascade")
     * @gedmo:TreeParent
     */
    protected $parent;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @orm:OneToMany(targetEntity="Yrch\YrchBundle\Entity\Category", mappedBy="parent")
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
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
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
     * Get children
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param string $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
}
