<?php

namespace Application\YrchBundle\Entity;

use DoctrineExtensions\Translatable\Translatable;

/**
 * Application\YrchBundle\Entity\Site
 *
 * @orm:Table(name="site")
 * @orm:Entity()
 * @orm:@TranslationEntity(class="Application\YrchBundle\Entity\SiteTranslation")
 */
class Site implements Translatable
{

    /**
     * @var integer $id
     *
     * @orm:Column(name="id", type="integer")
     * @orm:Id
     * @orm:GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $url
     *
     * @orm:Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string $title
     *
     * @orm:Column(name="title", type="string", length=255)
     * @orm:Translatable
     */
    private $title;

    /**
     * @var string $locale
     *
     * @orm:Locale
     */
    private $locale;

    /**
     * @var string $description
     *
     * @orm:Column(name="description", type="text")
     * @orm:Translatable
     */
    private $description;

    /**
     * @var string $createdAt
     *
     * @orm:Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string $updatedAt
     *
     * @orm:Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var string $selection
     *
     * @orm:Column(name="selection", type="boolean")
     */
    private $selection;

    /**
     * @var string $leech
     *
     * @orm:Column(name="leech", type="boolean")
     */
    private $leech;

    /**
     * @var string $status
     *
     * @orm:Column(name="status", type="string", length=100)
     */
    private $status;

    /**
     * @var string $notes
     *
     * @orm:Column(name="notes", type="text")
     */
    private $notes;

    /**
     * @orm:ManyToOne(targetEntity="Application\YrchBundle\Entity\User", inversedBy="sites")
     */
    private $owner;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
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
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set selection
     *
     * @param boolean $selection
     */
    public function setSelection($selection)
    {
        $this->selection = $selection;
    }

    /**
     * Get selection
     *
     * @return boolean $selection
     */
    public function getSelection()
    {
        return $this->selection;
    }

    /**
     * Set leech
     *
     * @param boolean $leech
     */
    public function setLeech($leech)
    {
        $this->leech = $leech;
    }

    /**
     * Get leech
     *
     * @return boolean $leech
     */
    public function getLeech()
    {
        return $this->leech;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set notes
     *
     * @param text $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * Get notes
     *
     * @return text $notes
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set owner
     *
     * @param User $user
     */
    public function setOwner(User $user)
    {
        $this->owner = $user;
    }

    /**
     * Get owner
     *
     * @return User $owner
     */
    public function getOwner()
    {
        return $this->owner;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

}