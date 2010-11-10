<?php

namespace Application\YrchBundle\Entity;

use DoctrineExtensions\Tree\Node;
use DoctrineExtensions\Tree\Configuration;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @orm:Entity(repositoryClass="DoctrineExtensions\Tree\Repository\TreeNodeRepository")
 * @orm:Table(name="category")
 */
class Category implements Node
{
    /**
     * @var integer $id
     *
     * @orm:Column(name="id", type="integer")
     * @orm:Id
     * @orm:GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @orm:Column(name="title", type="string", length=64)
     */
    private $title;

    /**
     * @var integer
     *
     * @orm:Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @var integer
     *
     * @orm:Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @var Category
     *
     * @orm:ManyToOne(targetEntity="Application\YrchBundle\Entity\Category", inversedBy="children")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @orm:OneToMany(targetEntity="Application\YrchBundle\Entity\Category", mappedBy="parent")
     * @orm:OrderBy({"lft" = "ASC"})
     */
    private $children;

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

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
     * Node interface method which must return
     * tree configuration, see this class
     * for options available. It mainly covers
     * parent, left, right field names
     * of your tree
     */
    public function getTreeConfiguration()
    {
        return new Configuration(); // standard
    }
}
