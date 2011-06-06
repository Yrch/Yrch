<?php

namespace Yrch\YrchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Yrch\YrchBundle\Entity\Review
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 *
 * @ORM\Table(name="review", indexes={
 *      @ORM\index(name="review_relations_idx", columns={"site_id", "owner_id", "status"})
 * })
 * @ORM\Entity()
 * @Gedmo\TranslationEntity(class="Yrch\YrchBundle\Entity\ReviewTranslation")
 */
class Review
{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer $score
     *
     * @Assert\Max(10)
     * @ORM\Column(name="score", type="integer", nullable="true")
     */
    protected $score;

    /**
     * @var string $locale
     *
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * @var string $text
     *
     * @Assert\NotBlank(message="Please enter the text of the review")
     * @ORM\Column(name="text", type="text")
     * @Gedmo\Translatable
     */
    protected $text;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", length=100)
     */
    protected $status;

    /**
     * @var User $owner
     *
     * @ORM\ManyToOne(targetEntity="Yrch\YrchBundle\Entity\User", inversedBy="reviews")
     */
    protected $owner;

    /**
     * @var Site $site
     *
     * @ORM\ManyToOne(targetEntity="Yrch\YrchBundle\Entity\Site", inversedBy="reviews")
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
     * @return string
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
