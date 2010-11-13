<?php

namespace Application\YrchBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Application\YrchBundle\Entity\Site
 *
 * @orm:Table(name="site")
 * @orm:Entity()
 * @Translatable:Entity(class="Application\YrchBundle\Entity\SiteTranslation")
 */
class Site
{

    /**
     * @var integer $id
     *
     * @orm:Column(name="id", type="integer")
     * @orm:Id
     * @orm:GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $url
     *
     * @validation:Validation({
     *      @validation:Url(message='This is not a valid url'),
     *      @validation:NotBlank(message='Please enter the url')
     * })
     * @orm:Column(name="url", type="string", length=255)
     */
    protected $url;

    /**
     * @var string $title
     *
     * @validation:NotBlank(message='Please enter the name')
     * @orm:Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string $locale
     *
     * @Translatable:Locale
     */
    protected $locale;

    /**
     * @var string $description
     *
     * @orm:Column(name="description", type="text")
     * @Translatable:Field
     */
    protected $description;

    /**
     * @var datetime $createdAt
     *
     * @orm:Column(name="created_at", type="datetime")
     * @Timestampable:OnCreate
     */
    protected $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @orm:Column(name="updated_at", type="datetime")
     * @Timestampable:OnUpdate
     */
    protected $updatedAt;

    /**
     * @var string $selection
     *
     * @validation:AssertType(type="boolean")
     * @orm:Column(name="selection", type="boolean")
     */
    protected $selection;

    /**
     * @var string $leech
     *
     * @validation:AssertType(type="boolean")
     * @orm:Column(name="leech", type="boolean")
     */
    protected $leech;

    /**
     * @var string $status
     *
     * @orm:Column(name="status", type="string", length=100)
     */
    protected $status;

    /**
     * @var string $notes
     *
     * @orm:Column(name="notes", type="text")
     */
    protected $notes;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @orm:OneToMany(targetEntity="Application\YrchBundle\Entity\Review", mappedBy="site")
     */
    protected $reviews;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $owners
     *
     * @orm:ManyToMany(targetEntity="Application\YrchBundle\Entity\User", inversedBy="sites")
     * @orm:JoinTable(name="user_site",
     *      joinColumns={@orm:JoinColumn(name="site_id", referencedColumnName="id")},
     *      inverseJoinColumns={@orm:JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    protected $owners;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $categories
     *
     * @orm:ManyToMany(targetEntity="Application\YrchBundle\Entity\Site")
     * @orm:JoinTable(name="site_category",
     *      joinColumns={@orm:JoinColumn(name="site_id", referencedColumnName="id")},
     *      inverseJoinColumns={@orm:JoinColumn(name="category_id", referencedColumnName="id")}
     *      )
     * @orm:OrderBy({"lft" = "ASC"})
     */
    protected $categories;

    public function  __construct()
    {
        $this->status = 'pending';
        $this->leech = false;
        $this->selection = false;
        $this->notes = '';
        $this->reviews = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->owners = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer $id
     * @codeCoverageIgnore
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
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
     * Get createdAt
     *
     * @return datetime $createdAt
     * @codeCoverageIgnore
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime $updatedAt
     * @codeCoverageIgnore
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add to selection
     */
    public function addToSelection()
    {
        $this->selection = true;
    }

    /**
     * Remove from selection
     *
     * @param boolean $selection
     */
    public function removeFromSelection()
    {
        $this->selection = false;
    }

    /**
     * Is in selection ?
     *
     * @return boolean
     */
    public function isSelectioned()
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
     * is leech ?
     *
     * @return boolean 
     */
    public function isLeech()
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
     * Add a review
     *
     * @param Review $review
     */
    public function addReview(Review $review)
    {
        if (!$this->getReviews()->contains($review)){
            $review->setSite($this);
            $this->getReviews()->add($review);
        }
    }

    /**
     * Get reviews
     *
     * @return Collection
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * Add an owner
     *
     * @param User $user
     */
    public function addOwner(User $user)
    {
        if (!$this->getOwners()->contains($user)){
            $user->addSite($this);
            $this->getOwners()->add($user);
        }
    }

    /**
     * Delete an owner
     *
     * @param User $user
     */
    public function removeOwner(User $user)
    {
        if ($this->getOwners()->contains($user)){
            if ($this->getOwners()->count() == 1){
                throw new \RuntimeException('A site must have at least one owner');
            }
            $this->getOwners()->removeElement($user);
        }
    }

    /**
     * Get owners
     *
     * @return ArrayCollection $owners
     */
    public function getOwners()
    {
        return $this->owners;
    }

    /**
     * Add category
     *
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        if (!$this->getCategories()->contains($category)){
            $this->getCategories()->add($category);
        }
    }

    /**
     * Remove category
     *
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->getCategories()->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return Collection $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

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
