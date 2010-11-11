<?php

namespace Application\YrchBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Application\YrchBundle\Entity\Review
 *
 * @orm:Table(name="review")
 * @orm:Entity()
 * @TranslationEntity(class="Application\YrchBundle\Entity\ReviewTranslation")
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
    private $id;

    /**
     * @var integer $score
     *
     * @orm:Column(name="score", type="integer", nullable="true")
     */
    private $score;

    /**
     * @var string $locale
     *
     * @Locale
     */
    private $locale;

    /**
     * @var string $text
     *
     * @orm:Column(name="text", type="text")
     * @Translatable
     */
    private $text;

    /**
     * @var datetime $createdAt
     *
     * @orm:Column(name="created_at", type="datetime")
     * @Timestampable:OnCreate
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @orm:Column(name="updated_at", type="datetime")
     * @Timestampable:OnUpdate
     */
    private $updatedAt;

    /**
     * @var string $status
     *
     * @orm:Column(name="status", type="string", length=100)
     */
    private $status;

    /**
     * @var User $owner
     *
     * @orm:ManyToOne(targetEntity="Application\YrchBundle\Entity\User", inversedBy="reviews")
     */
    private $owner;

    /**
     * @var Site $site
     *
     * @orm:ManyToOne(targetEntity="Application\YrchBundle\Entity\Site", inversedBy="reviews")
     */
    private $site;

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
}
