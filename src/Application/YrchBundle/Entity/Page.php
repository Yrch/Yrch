<?php

namespace Application\YrchBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Page
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 *
 * @orm:Entity()
 * @orm:Table(name="page")
 */
class Page
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
     * @orm:Column(name="name", type="string", length=255, unique="true")
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
     * @var string
     *
     * @orm:Column(name="content", type="text")
     * @gedmo:Translatable
     */
    protected $content;

    /**
     * @var \DateTime $createdAt
     *
     * @orm:Column(name="created_at", type="datetime")
     * @gedmo:Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @orm:Column(name="updated_at", type="datetime")
     * @gedmo:Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @var User
     *
     * @orm:ManyToOne(targetEntity="Application\YrchBundle\Entity\User")
     */
    protected $modifier;

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
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the last modifier
     *
     * @return User $user
     */
    public function setLastmodifier(User $user)
    {
        $this->modifier = $user;
    }

    /**
     * Get the last modifier
     *
     * @return User
     */
    public function getLastmodifier()
    {
        return $this->modifier;
    }

    /**
     * @param string $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Set the creation date.
     *
     * This is only used when you remove the TranslationListener to force the
     * creation date. In other case I will be overwritten by the Translatable
     * behavior.
     *
     * @param \DateTime $created_at
     */
    public function setCreatedAt(\DateTime $created_at)
    {
        $this->createdAt = $created_at;
    }

    /**
     * Set the update date.
     *
     * This is only used when you remove the TranslationListener to force the
     * creation date. In other case I will be overwritten by the Translatable
     * behavior.
     *
     * @param \DateTime $updated_at
     */
    public function setUpdatedAt(\DateTime $updated_at)
    {
        $this->updatedAt = $updated_at;
    }
}
