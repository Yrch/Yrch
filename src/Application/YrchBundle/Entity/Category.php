<?php

namespace Application\YrchBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @orm:Entity(repositoryClass="Gedmo\Tree\Repository\TreeNodeRepository")
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
     * @orm:ManyToOne(targetEntity="Application\YrchBundle\Entity\Category", inversedBy="children")
     * @gedmo:TreeParent
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
     * @param string $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
}
