<?php

namespace Application\YrchBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Application\YrchBundle\Entity\Review
 *
 * @orm:Table(name="review", indexes={
 *      @orm:index(name="review_relations_idx", columns={"site_id", "owner_id", "status"})
 * })
 * @orm:Entity()
 * @gedmo:TranslationEntity(class="Application\YrchBundle\Entity\ReviewTranslation")
 */
class Review
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
     * @var integer $score
     *
     * @validation:Max(10)
     * @orm:Column(name="score", type="integer", nullable="true")
     */
    protected $score;

    /**
     * @var string $locale
     *
     * @gedmo:Locale
     */
    protected $locale;

    /**
     * @var string $text
     *
     * @validation:NotBlank(message="Please enter the text of the review")
     * @orm:Column(name="text", type="text")
     * @gedmo:Translatable
     */
    protected $text;

    /**
     * @var datetime $createdAt
     *
     * @orm:Column(name="created_at", type="datetime")
     * @gedmo:Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @orm:Column(name="updated_at", type="datetime")
     * @gedmo:Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @var string $status
     *
     * @orm:Column(name="status", type="string", length=100)
     */
    protected $status;

    /**
     * @var User $owner
     *
     * @orm:ManyToOne(targetEntity="Application\YrchBundle\Entity\User", inversedBy="reviews")
     */
    protected $owner;

    /**
     * @var Site $site
     *
     * @orm:ManyToOne(targetEntity="Application\YrchBundle\Entity\Site", inversedBy="reviews")
     */
    protected $site;

    public function  __construct()
    {
        $this->status = 'pending';
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
     * @param integer|null $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * Get url
     *
     * @return integer|null
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set text
     *
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
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
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set site
     *
     * @param Site $site
     */
    public function setSite(Site $site)
    {
        $this->site = $site;
    }

    /**
     * Get site
     *
     * @return Site
     */
    public function getSite()
    {
        return $this->site;
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
